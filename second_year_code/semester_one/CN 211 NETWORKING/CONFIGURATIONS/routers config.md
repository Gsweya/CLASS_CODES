# CN 211 Router Configuration Steps (How We Did It)

This document focuses only on router work: the sequence, the exact logic used in your project, and the OSI layer impact of each configuration choice.

References used from this project:
- `routers_clean/UDOM-ROUTER_clean.txt`
- `routers_clean/BUNGE-ROUTER_clean.txt`
- `routers_clean/MIPANGO-ROUTER_clean.txt`
- `routers_clean/CBE-ROUTER_clean.txt`
- `reference/CLOUD_FRAME_RELAY_PVC_TABLE.txt`

---

## 1. Router Build Strategy We Used

We configured each router in the same order to avoid mistakes:

1. Start global identity and DNS helpers.
2. Configure LAN interfaces (`Gi`).
3. Configure WiFi gateway path (`Fa` switchports + `Vlan1` SVI).
4. Configure WAN serial (`Se0/1/0`) with Frame Relay.
5. Disable unused interfaces.
6. Configure DHCP pools for user and WiFi networks.
7. Add static routes to all remote subnets.
8. Save and verify.

Why this order works:
- It brings local connectivity up first, then WAN, then services (DHCP/DNS pointers), then routing.
- Troubleshooting becomes simpler because each stage depends on the previous stage.

---

## 2. Layer-Based View: Why Layer Influences Config Choices

| Step | Main Commands | OSI Layer | Why Layer Matters for Config |
|---|---|---|---|
| Physical readiness | module install, correct cabling, `no shut` | L1 | If L1 is wrong, higher-layer configs cannot work regardless of correctness. |
| Access switching path | `interface range fa0/0/0-3`, access VLAN | L2 | AP/users on switchports need L2 forwarding before IP routing can happen. |
| WAN encapsulation | `encapsulation frame-relay` | L2 | WAN cloud uses virtual circuits; IP packets cannot traverse without correct data-link encapsulation. |
| Interface IP/gateway | `ip address ...` on `Gi`, `Vlan1`, `Se` | L3 | Routing decisions require correct Layer-3 addressing and subnet boundaries. |
| Inter-network paths | `ip route ...` | L3 | Without routes, packets stop at first router even if interfaces are up. |
| DHCP service | `ip dhcp pool`, `default-router`, `dns-server` | L7 (service) over L3 | DHCP automates L3 settings; wrong options cause host-side failures despite healthy routers. |
| DNS helper on router | `ip name-server`, `ip host` | L7 (service use) | Router CLI name resolution helps tests and operations; no impact on forwarding plane but impacts manageability. |

Practical rule:
- L1/L2 errors look like link/PVC failures.
- L3 errors look like unreachable remote subnets.
- L7 service errors look like “IP works but domain/web behavior fails.”

---

## 3. Step-by-Step Router Configuration (Exactly How It Was Done)

## Step 0: Enter config mode and set identity

Commands:
```cisco
enable
conf t
hostname <SITE>-ROUTER
```

Layer impact:
- Control/management plane (not forwarding directly), but essential for operations and readable CLI evidence.

Why we do this first:
- Prevents confusion when multiple routers are open in parallel tabs/windows.

---

## Step 1: Configure router-side DNS behavior for operations

Commands used:
```cisco
ip domain-lookup
ip name-server <local_server_dns_ip>
ip host www.udom.ac.tz 10.1.2.2
ip host www.bunge.gov.tz 10.2.2.2
ip host www.mipango.ac.tz 10.3.2.2
ip host www.cbe.ac.tz 10.4.2.2
```

Layer:
- L7 usage (DNS naming service behavior on CLI).

Why this influences config:
- We point each router to its local DNS server (`10.x.2.2`) for locality.
- `ip host` entries provide fallback hostname mapping during partial DNS issues.

---

## Step 2: Configure User LAN interface

Example pattern:
```cisco
interface GigabitEthernet<port>
 ip address 10.x.1.1 255.255.255.0
 no shutdown
exit
```

Layer:
- L3 interface gateway.

Why this influences config:
- User PCs need a default gateway in `10.x.1.0/24`; we always use `.1` as gateway for consistency.

---

## Step 3: Configure Server LAN interface

Example pattern:
```cisco
interface GigabitEthernet<port>
 ip address 10.x.2.1 255.255.255.0
 no shutdown
exit
```

Layer:
- L3 interface gateway.

Why this influences config:
- DNS/HTTP servers have static IP `10.x.2.2`; gateway must be `10.x.2.1` on the correct physical interface.
- Wrong port usage here causes “server unreachable” even with correct IPs.

---

## Step 4: Configure AP switching path and WiFi gateway

Commands used:
```cisco
interface range FastEthernet0/0/0 - 3
 switchport mode access
 switchport access vlan 1
 no shutdown
exit

interface Vlan1
 ip address 10.x.3.1 255.255.255.0
 no shutdown
exit
```

Layer:
- `Fa0/0/0-3` config is L2.
- `Vlan1` SVI is L3.

Why this influences config:
- AP is connected through router switchport path (`Fa0/0/0`) so it belongs to VLAN 1 (L2 segment).
- Hosts still need an IP gateway, so `Vlan1` provides Layer-3 gateway (`10.x.3.1`) for WiFi subnet.

---

## Step 5: Configure WAN serial with Frame Relay

Commands used:
```cisco
interface Serial0/1/0
 ip address 10.10.10.<site_id> 255.255.255.0
 encapsulation frame-relay
 no shutdown
exit
```

Layer:
- IP address is L3.
- Frame Relay encapsulation is L2.

Why this influences config:
- Cloud-PT WAN in this project is Frame Relay PVC based.
- If encapsulation is missing or mismatched, IP routing over WAN fails even if interface appears up.

---

## Step 6: Shut down unused interfaces

Commands used (site-dependent):
```cisco
interface GigabitEthernet<unused>
 no ip address
 shutdown
exit

interface Serial0/1/1
 shutdown
exit
```

Layer:
- L1/L2/L3 operational hygiene.

Why this influences config:
- Reduces accidental misconfiguration and simplifies troubleshooting.
- Cleaner exam demonstration: only intended paths are active.

---

## Step 7: Configure DHCP exclusions and pools

Commands used:
```cisco
ip dhcp excluded-address 10.x.1.1 10.x.1.20
ip dhcp excluded-address 10.x.2.1 10.x.2.20
ip dhcp excluded-address 10.x.3.1 10.x.3.20

ip dhcp pool <SITE>_LAN_USERS
 network 10.x.1.0 255.255.255.0
 default-router 10.x.1.1
 dns-server 10.x.2.2
exit

ip dhcp pool <SITE>_WIFI
 network 10.x.3.0 255.255.255.0
 default-router 10.x.3.1
 dns-server 10.x.2.2
exit
```

Layer:
- DHCP is an application/service layer function (L7) that provides L3 parameters.

Why this influences config:
- Exclusions reserve infrastructure range and prevent lease conflicts.
- Correct DHCP options are critical: wrong gateway or DNS causes host failures despite healthy router interfaces.

---

## Step 8: Configure static routes to all remote subnets

Command pattern:
```cisco
ip route <remote_subnet> 255.255.255.0 <remote_router_wan_ip>
```

Layer:
- L3 routing control.

Why this influences config:
- Each router knows only directly connected networks by default.
- Static routes explicitly teach paths for all remote user/server/wifi networks.

Example from UDOM:
```cisco
ip route 10.2.1.0 255.255.255.0 10.10.10.3
ip route 10.2.2.0 255.255.255.0 10.10.10.3
ip route 10.2.3.0 255.255.255.0 10.10.10.3
ip route 10.3.1.0 255.255.255.0 10.10.10.4
ip route 10.3.2.0 255.255.255.0 10.10.10.4
ip route 10.3.3.0 255.255.255.0 10.10.10.4
ip route 10.4.1.0 255.255.255.0 10.10.10.5
ip route 10.4.2.0 255.255.255.0 10.10.10.5
ip route 10.4.3.0 255.255.255.0 10.10.10.5
```

---

## Step 9: Save configuration

Commands:
```cisco
end
wr
```

Layer:
- Operational persistence (startup behavior), not packet-forwarding layer specific.

Why this influences config:
- Ensures router does not lose all work after reload/power-cycle.

---

## 4. Site-by-Site Router Interface Decisions (How It Was Done)

## UDOM Router
- Users: `Gi0/0 = 10.1.1.1/24`
- Server: `Gi0/1 = 10.1.2.1/24`
- WiFi gateway: `Vlan1 = 10.1.3.1/24`
- WAN: `Se0/1/0 = 10.10.10.2/24`
- Unused: `Gi0/2`, `Se0/1/1` shutdown

Reason:
- Port layout aligns physical cabling to planned subnets exactly.

## BUNGE Router
- Users: `Gi0/0 = 10.2.1.1/24`
- Server: `Gi0/2 = 10.2.2.1/24`
- WiFi gateway: `Vlan1 = 10.2.3.1/24`
- WAN: `Se0/1/0 = 10.10.10.3/24`
- Unused: `Gi0/1`, `Se0/1/1` shutdown

Reason:
- Different Gig port selected for server due to physical topology mapping, while keeping same subnet logic.

## MIPANGO Router
- Users: `Gi0/2 = 10.3.1.1/24`
- Server: `Gi0/1 = 10.3.2.1/24`
- WiFi gateway: `Vlan1 = 10.3.3.1/24`
- WAN: `Se0/1/0 = 10.10.10.4/24`
- Unused: `Gi0/0`, `Se0/1/1` shutdown

Reason:
- Maintains same functional role separation while matching physical cable map.

## CBE Router
- Users: `Gi0/1 = 10.4.1.1/24`
- Server: `Gi0/0 = 10.4.2.1/24`
- WiFi gateway: `Vlan1 = 10.4.3.1/24`
- WAN: `Se0/1/0 = 10.10.10.5/24`
- Unused: `Gi0/2`, `Se0/1/1` shutdown

Reason:
- Same pattern consistency; only interface numbers differ due to placement/cabling design.

---

## 5. WAN Cloud Pairing and Router Effect

Cloud full mesh pairs:
1. Se0 (UDOM) <-> Se1 (MIPANGO)
2. Se0 (UDOM) <-> Se2 (BUNGE)
3. Se0 (UDOM) <-> Se3 (CBE)
4. Se1 (MIPANGO) <-> Se2 (BUNGE)
5. Se1 (MIPANGO) <-> Se3 (CBE)
6. Se2 (BUNGE) <-> Se3 (CBE)

Why 6:
- Full mesh formula `n(n-1)/2` with `n=4` routers gives `6`.

Layer impact:
- This is primarily L2 WAN virtual-circuit mapping.
- L3 static routes depend on these L2 paths being active.

If this is wrong:
- `show frame-relay pvc` shows inactive PVCs,
- some or all inter-campus routes fail to pass traffic.

---

## 6. Verification Commands Mapped to Layer

| Command | Layer Validated | What It Proves |
|---|---|---|
| `show ip int brief` | L1/L3 | Interface state and assigned IPs are correct. |
| `show frame-relay pvc` | L2 | WAN virtual circuits are active. |
| `show ip route` | L3 | Router has next-hop knowledge for all remote subnets. |
| `show ip dhcp binding` | L7 service + L3 output | Hosts received proper addressing parameters. |
| `ping <remote_ip>` | L3 | Network-layer reachability across WAN. |
| domain-based web test | L7 end-to-end | DNS + HTTP + routing all working together. |

---

## 7. Why These Layer Decisions Influence Router Config Quality

1. If L2 WAN isn’t correct (`encapsulation frame-relay` + PVC), L3 routes are useless.
2. If L3 gateway IPs are wrong, DHCP may still lease addresses but hosts cannot route.
3. If L7 DHCP options are wrong, hosts appear connected but fail DNS or remote access.
4. If interface-role mapping is inconsistent (server on wrong Gi port), troubleshooting complexity increases.
5. Layer-aware configuration order reduces error chains and speeds live debugging.

In short:
- Layer understanding is not theory only; it determines command order, interface role choice, and fault isolation speed.

---

## 8. Fast Viva Script (Router Configuration)

"We configured each router in a layered sequence: physical readiness, then Layer-2 access and WAN encapsulation, then Layer-3 interface IPs and static routes, then Layer-7 host services via DHCP/DNS options. The AP path uses switchports in VLAN 1 at Layer 2, and `Vlan1` SVI provides WiFi gateway at Layer 3. WAN uses `Serial0/1/0` with Frame Relay encapsulation because the cloud is PVC-based. Static routes map every remote subnet to the correct WAN next hop. We verified by interface status, PVC state, route table, DHCP bindings, and end-to-end domain web access." 

