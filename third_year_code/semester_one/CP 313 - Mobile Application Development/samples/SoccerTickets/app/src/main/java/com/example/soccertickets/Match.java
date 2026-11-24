package com.example.soccertickets;

/** One football match. Plain Java class: fields + constructor + small helper methods. */
public class Match {

    public static final String UPCOMING = "UPCOMING";
    public static final String LIVE = "LIVE";
    public static final String FULL_TIME = "FULL TIME";

    public String homeTeam;
    public String awayTeam;
    public String stadium;
    public String kickoff;
    public int regularPrice;
    public int vipPrice;
    public int seatsLeft;
    public String status;
    public int minute;
    public int homeScore;
    public int awayScore;

    public Match(String homeTeam, String awayTeam, String stadium, String kickoff,
                 int regularPrice, int vipPrice, int seatsLeft, String status, int minute) {
        this.homeTeam = homeTeam;
        this.awayTeam = awayTeam;
        this.stadium = stadium;
        this.kickoff = kickoff;
        this.regularPrice = regularPrice;
        this.vipPrice = vipPrice;
        this.seatsLeft = seatsLeft;
        this.status = status;
        this.minute = minute;
        this.homeScore = 0;
        this.awayScore = 0;
    }

    public String getTitle() {
        return homeTeam + " vs " + awayTeam;
    }

    /** e.g. "LIVE 67' : 2 - 1", "FULL TIME : 1 - 0" or "Kick-off Sat 16:00" */
    public String getScoreLine() {
        if (status.equals(LIVE)) {
            return "LIVE " + minute + "'  :  " + homeScore + " - " + awayScore;
        } else if (status.equals(FULL_TIME)) {
            return "FULL TIME  :  " + homeScore + " - " + awayScore;
        } else {
            return "Kick-off " + kickoff;
        }
    }

    /** Tickets can be bought until full time, while seats are left. */
    public boolean canBuy() {
        return !status.equals(FULL_TIME) && seatsLeft > 0;
    }

    /** The text shown for this match in the list. */
    public String toListText() {
        String seats;
        if (status.equals(FULL_TIME)) {
            seats = "Sales closed";
        } else if (seatsLeft == 0) {
            seats = "SOLD OUT";
        } else {
            seats = seatsLeft + " seats left";
        }
        return getTitle() + "\n" + getScoreLine() + "\n" + stadium + "  ·  " + seats;
    }
}
