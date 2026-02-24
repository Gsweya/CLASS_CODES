# CN 211 Network Configuration Presentation Notes

## 1. Executive Summary

This project implements a multi-campus routed network using four Cisco 2911 routers (UDOM, BUNGE, MIPANGO, CBE), a Cloud-PT Frame Relay WAN core, local DNS+HTTP servers at each site, DHCP for users and wireless clients, and static routing for inter-campus reachability.

The design goal is to allow any host in any campus to:
- receive IP settings automatically,
- resolve all institutional domain names,
- access all institutional web pages,
- traverse WAN links through a cloud-based full-mesh mapping.

The structure is deterministic, easy to explain in viva, and easy to verify using CLI.

## 2. Topology and Interface Mapping (As Implemented)

| Site | User LAN Interface | Server LAN Interface | WiFi Access Interface | WAN Interface | WAN IP |
|---|---|---|---|---|---|
| UDOM | `Gi0/0` -> `10.1.1.1/24` | `Gi0/1` -> `10.1.2.1/24` | `Vlan1` -> `10.1.3.1/24` via `Fa0/0/0` AP path | `Se0/1/0` | `10.10.10.2/24` |
| BUNGE | `Gi0/0` -> `10.2.1.1/24` | `Gi0/2` -> `10.2.2.1/24` | `Vlan1` -> `10.2.3.1/24` via `Fa0/0/0` AP path | `Se0/1/0` | `10.10.10.3/24` |
| MIPANGO | `Gi0/2` -> `10.3.1.1/24` | `Gi0/1` -> `10.3.2.1/24` | `Vlan1` -> `10.3.3.1/24` via `Fa0/0/0` AP path | `Se0/1/0` | `10.10.10.4/24` |
| CBE | `Gi0/1` -> `10.4.1.1/24` | `Gi0/0` -> `10.4.2.1/24` | `Vlan1` -> `10.4.3.1/24` via `Fa0/0/0` AP path | `Se0/1/0` | `10.10.10.5/24` |

Cloud serial-port attachment:
- Cloud `Se0` <-> UDOM `Se0/1/0`
- Cloud `Se2` <-> BUNGE `Se0/1/0`
- Cloud `Se1` <-> MIPANGO `Se0/1/0`
- Cloud `Se3` <-> CBE `Se0/1/0`

## 3. Why This IP Design Works

Addressing model:
- UDOM: `10.1.1.0/24` (users), `10.1.2.0/24` (server), `10.1.3.0/24` (wifi)
- BUNGE: `10.2.1.0/24`, `10.2.2.0/24`, `10.2.3.0/24`
- MIPANGO: `10.3.1.0/24`, `10.3.2.0/24`, `10.3.3.0/24`
- CBE: `10.4.1.0/24`, `10.4.2.0/24`, `10.4.3.0/24`
- WAN transit: `10.10.10.0/24`

Reasons:
- clean campus grouping by second octet,
- clear functional grouping by third octet (`1=user`, `2=server`, `3=wifi`),
- no subnet overlap,
- easy static routing and troubleshooting,
- enough host scale per subnet (254 usable hosts each `/24`).

## 4. OSI Layer-by-Layer Explanation (What Works at Each Layer)

## Layer 1: Physical

What exists:
- copper Ethernet links for LAN connections (router-to-switch, router-to-server path, AP path),
- serial physical links for WAN (router `Se0/1/0` to cloud serial ports),
- hardware modules: `HWIC-2T` on routers and `PT-CLOUD-NM-1S` on cloud.

What this layer is responsible for:
- signal transmission,
- cable/module correctness,
- interface up/down electrical state.

Key checks:
- `show ip interface brief` for status/protocol,
- packet tracer physical tab confirms modules installed.

Typical failures:
- wrong cable type or unplugged cable -> interface down/down,
- missing serial modules -> no serial ports available.

## Layer 2: Data Link

What exists:
- Ethernet switching for LAN segments,
- `Fa0/0/0-3` configured as access switchports in VLAN 1,
- AP connected as Layer-2 access member of VLAN 1 path,
- Frame Relay encapsulation on serial interface for WAN virtual circuits.

Critical configs:
- `switchport mode access`
- `switchport access vlan 1`
- `encapsulation frame-relay`

What works here:
- local frame forwarding inside LAN/WiFi broadcast domain,
- virtual-circuit forwarding inside cloud using Frame Relay PVCs.

Key checks:
- `show frame-relay pvc` -> must be `ACTIVE`,
- if serial is up but traffic fails, PVC mapping is usually wrong.

Typical failures:
- VLAN mismatch or wrong port used for AP path,
- missing cloud pair mapping,
- directional cloud entries missing (if required).

## Layer 3: Network

What exists:
- IPv4 addressing on router LAN and WAN interfaces,
- static routes to all remote subnets,
- default gateway assignment via DHCP.

Critical configs:
- interface IP addresses on `Gi`, `Vlan1`, and `Se0/1/0`,
- `ip route` statements to remote campus networks.

What works here:
- end-to-end campus interconnection,
- deterministic next-hop path selection.

Key checks:
- `show ip route`,
- `ping` remote gateways and server IPs.

Typical failures:
- wrong next-hop in static route,
- wrong server subnet interface selection,
- missing route to one remote subnet.

## Layer 4: Transport

What exists:
- TCP for HTTP sessions,
- UDP/TCP for DNS queries and replies,
- transport sessions between clients and remote servers across WAN.

What works here:
- reliable page delivery over TCP after Layer 3 path is successful,
- DNS transactions for name resolution before HTTP access.

Key checks:
- domain resolution works (`nslookup`/name ping),
- web page opens by domain name and by IP.

Typical failures:
- DNS service off (name fails, IP-based browsing may still work),
- HTTP service off (name resolves but page fails).

## Layer 5: Session

What exists:
- session establishment and maintenance between browser and HTTP server,
- persistent user interaction flow from campus clients to remote server applications.

What works here:
- connection setup/teardown for browser sessions,
- session continuity over routed WAN.

Failure symptom:
- intermittent connectivity can break sessions even if routing appears mostly correct.

## Layer 6: Presentation

What exists:
- formatting of application content (`index.html`) and data representation.

What works here:
- users see institution-specific web content correctly rendered,
- application data appears meaningful and readable.

Failure symptom:
- transport works but malformed page content displays incorrectly.

## Layer 7: Application

What exists:
- DHCP service from routers,
- DNS service on each server,
- HTTP service on each server.

What works here:
- client auto-IP assignment (DHCP),
- domain-to-IP translation (DNS),
- webpage delivery (HTTP).

Key checks:
- `show ip dhcp binding`,
- DNS records on each server include all 4 domains,
- HTTP service enabled with institution-specific page.

## 5. Cable Choices and Justification

LAN cabling:
- Use Ethernet copper (straight-through in Packet Tracer norms; auto-select also valid).
- Reason: connecting unlike LAN device types in campus access design and preserving simple Layer-2 behavior.

WAN cabling:
- Use serial links from router `Se0/1/0` to cloud serial ports.
- Reason: WAN simulation is built on serial Frame Relay, not Ethernet switching.

Why this matters in presentation:
- Cable type is not cosmetic; it indicates the technology domain:
  - Ethernet copper means local LAN segment,
  - serial means provider-style WAN segment.

## 6. Why Specific Interfaces Were Used

`Gi` interfaces:
- routed LAN gateways for user and server networks.
- each campus uses two routed Gig interfaces for separated LAN roles.

`Fa0/0/0` path + `Vlan1`:
- AP plugs into integrated switchport path (Layer 2),
- gateway must be on SVI (`interface Vlan1`) because switchports themselves are not routed interfaces.

`Se0/1/0`:
- dedicated WAN uplink toward cloud,
- frame-relay encapsulation matches cloud provider model.

Unused interfaces set to `shutdown`:
- reduces ambiguity,
- avoids accidental addressing and security exposure,
- improves operational cleanliness.

## 7. Cloud Configuration and Why There Are 6 Mappings

The cloud is configured as a full mesh among 4 sites.

Mathematical reason:
- Number of unique undirected pairs in a full mesh = `n(n-1)/2`.
- For `n=4` routers: `4*3/2 = 6`.

Required pairs:
1. Se0 (UDOM) <-> Se1 (MIPANGO)
2. Se0 (UDOM) <-> Se2 (BUNGE)
3. Se0 (UDOM) <-> Se3 (CBE)
4. Se1 (MIPANGO) <-> Se2 (BUNGE)
5. Se1 (MIPANGO) <-> Se3 (CBE)
6. Se2 (BUNGE) <-> Se3 (CBE)

Why full mesh was chosen:
- every campus has direct WAN virtual connectivity to each other campus,
- static routing remains straightforward,
- failure isolation is easier during demonstration.

What happens if one mapping is missing:
- some campuses can still communicate while others fail,
- `show frame-relay pvc` reveals non-active PVCs for broken pair.

## 8. Why Each Router Setting Was Used

`ip domain-lookup`:
- allows DNS resolution from router CLI.

`ip name-server 10.x.2.2`:
- points router to local campus DNS server.

`ip host ...` entries:
- local static hostname fallback mappings, useful during partial DNS issues.

`ip dhcp excluded-address 10.x.y.1 10.x.y.20`:
- reserves gateway and infrastructure range from dynamic allocation.

`ip dhcp pool` with `default-router` and `dns-server`:
- auto-distributes correct gateway and DNS to end users.

`encapsulation frame-relay` on serial:
- mandatory to make cloud virtual-circuit transport consistent.

`ip route ... next-hop`:
- manually defines remote reachability in a controlled topology.

`wr`:
- saves running configuration to startup.

## 9. End-to-End Packet Flow (Explain in Viva)

Example: WiFi laptop at UDOM opens `www.cbe.ac.tz`.

1. Laptop joins UDOM AP SSID and gets DHCP lease from `UDOM-ROUTER` WiFi pool (`10.1.3.0/24`).
2. Laptop receives:
   - IP in `10.1.3.x`,
   - default gateway `10.1.3.1`,
   - DNS server `10.1.2.2`.
3. Laptop sends DNS query for `www.cbe.ac.tz` to `10.1.2.2`.
4. DNS server replies with `10.4.2.2`.
5. Laptop sends packet to destination `10.4.2.2`; gateway forwards to UDOM router.
6. UDOM router uses static route pointing to next-hop `10.10.10.5` via WAN serial.
7. Frame Relay cloud forwards packet through active PVC toward CBE router.
8. CBE router routes to local server LAN `10.4.2.0/24`.
9. CBE server HTTP responds; reverse path follows routing back to UDOM laptop.
10. Browser renders CBE webpage.

This flow proves all layers from physical to application are functioning.

## 10. Strong Verification Sequence (Live Demo Order)

Run this sequence for confidence:

1. `show ip int brief` on each router.
2. `show frame-relay pvc` on each router.
3. `show ip route` on each router.
4. `show ip dhcp binding` where clients are connected.
5. Ping tests:
   - local server IP,
   - remote server IPs (`10.1.2.2`, `10.2.2.2`, `10.3.2.2`, `10.4.2.2`).
6. DNS tests for all four domains.
7. Browser tests for all four websites from different campuses.

Expected outcome:
- interfaces up/up,
- PVCs active,
- routes present,
- DHCP leases populated,
- domain name resolution successful,
- websites open cross-campus.

## 11. Troubleshooting by Layer (Examiner-Grade)

| Symptom | Most Likely Layer | Root Cause | Fast Proof | Fix |
|---|---|---|---|---|
| Interface down/down | L1 | wrong cable/module/power | `show ip int brief` | correct cable, module, no shut |
| Serial up/up but no remote reachability | L2 | missing PVC pair | `show frame-relay pvc` | add correct cloud sublink pair |
| Can ping local gateway but not remote subnet | L3 | missing static route | `show ip route` | add missing `ip route` |
| Domain fails but IP ping works | L7 | DNS config/record issue | query DNS / check records | correct DNS service and A records |
| Domain resolves but web page does not open | L7/L4 | HTTP off or server path issue | ping server + check HTTP service | enable HTTP, verify server interface path |
| WiFi client no IP | L2/L7 | AP path or DHCP pool issue | check DHCP binding and VLAN1 | fix AP link, pool, or SVI |

## 12. Likely Viva Questions with Strong Answers

1. Why did you use static routing and not OSPF/RIP?
   We chose static routing because the topology is small and fixed; static routes are deterministic, easy to audit, and easy to defend during assessment.

2. Why separate users, server, and WiFi into different subnets?
   Segmentation reduces broadcast scope, isolates services, improves fault isolation, and makes policy extension easier.

3. Why is AP traffic using `Vlan1` gateway?
   AP connects through router switchports (Layer 2). The routed gateway for that VLAN must be an SVI (`interface Vlan1`).

4. Why 6 cloud mappings?
   Full mesh among 4 nodes requires 6 unique pairs (`n(n-1)/2`).

5. Why keep server IPs static?
   DNS and HTTP targets must be stable for all clients and all static DNS records.

6. Why exclude `.1-.20` in DHCP scopes?
   Infrastructure reservation for gateways, static services, and growth without lease conflicts.

7. How do you distinguish DNS failure from routing failure?
   Routing failure breaks both IP and name-based reachability. DNS failure still allows direct IP communication while domain lookup fails.

8. Why include `ip host` lines on routers when DNS exists?
   They provide immediate fallback hostname mappings and operational resilience for CLI-level testing.

9. What would break if one cloud PVC mapping is removed?
   Reachability between that pair of sites fails, potentially causing asymmetric campus communication even while others remain functional.

10. How do you prove end-to-end functionality to examiner quickly?
   Show interface status, PVC active state, route table entries, DHCP leases, then perform domain-based web access across all campuses.

## 13. Presentation Delivery Plan (10-12 Minutes)

Minute 1:
- state objective and architecture (4 campuses + cloud WAN).

Minute 2-3:
- explain IP plan and subnet logic (`10.x.1`, `10.x.2`, `10.x.3`).

Minute 4-5:
- explain interfaces and cable choices with reasons.

Minute 6:
- explain cloud frame-relay concept and why 6 mappings.

Minute 7-8:
- explain services: DHCP, DNS, HTTP and how they interact.

Minute 9:
- show end-to-end packet flow example.

Minute 10:
- run verification commands and demonstrate websites.

Minute 11-12:
- answer viva using layer-based troubleshooting framework.

## 14. High-Confidence Closing Statement

This network is functionally correct because every required control plane and data plane component is aligned:
- physical links and modules are correct,
- Frame Relay PVC mesh is active,
- Layer-3 addressing and static routes are complete,
- DHCP distributes valid client parameters,
- DNS resolves all institutional domains,
- HTTP services are reachable from every campus.

Therefore, the design satisfies core assignment goals: inter-campus connectivity, name resolution, web access, wireless integration, and defendable configuration rationale.

## 15. Source Files in This Project

- `routers_clean/UDOM-ROUTER_clean.txt`
- `routers_clean/BUNGE-ROUTER_clean.txt`
- `routers_clean/MIPANGO-ROUTER_clean.txt`
- `routers_clean/CBE-ROUTER_clean.txt`
- `reference/CLOUD_FRAME_RELAY_PVC_TABLE.txt`
- `reference/AP_SETUP.txt`
- `servers/UDOM-SERVER_setup.txt`
- `servers/BUNGE-SERVER_setup.txt`
- `servers/MIPANGO-SERVER_setup.txt`
- `servers/CBE-SERVER_setup.txt`
