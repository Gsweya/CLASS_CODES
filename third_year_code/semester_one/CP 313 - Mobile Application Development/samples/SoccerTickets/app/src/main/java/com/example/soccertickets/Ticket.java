package com.example.soccertickets;

/** One ticket the user bought. */
public class Ticket {

    public String code;
    public String buyerName;
    public String phone;
    public String matchTitle;
    public String type;        // "Regular" or "VIP"
    public int quantity;
    public int total;
    public boolean pickedUp;   // false until collected at the gate

    public Ticket(String code, String buyerName, String phone, String matchTitle,
                  String type, int quantity, int total) {
        this.code = code;
        this.buyerName = buyerName;
        this.phone = phone;
        this.matchTitle = matchTitle;
        this.type = type;
        this.quantity = quantity;
        this.total = total;
        this.pickedUp = false;
    }

    public String toListText() {
        String state;
        if (pickedUp) {
            state = "PICKED UP";
        } else {
            state = "Not picked up";
        }
        return code + "  ·  " + matchTitle + "\n"
                + quantity + " x " + type + "  ·  " + DataStore.money(total) + "  ·  " + state;
    }
}
