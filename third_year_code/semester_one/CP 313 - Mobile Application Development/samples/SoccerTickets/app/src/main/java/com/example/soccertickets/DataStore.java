package com.example.soccertickets;

import java.util.ArrayList;
import java.util.Locale;
import java.util.Random;

/**
 * TEMPORARY storage: plain static lists in memory (no database yet).
 * Every screen reads and writes the same lists, so they all see the same data.
 * Everything is lost when Android closes the app.
 */
public class DataStore {

    public static ArrayList<Match> matches = new ArrayList<Match>();
    public static ArrayList<Ticket> tickets = new ArrayList<Ticket>();

    private static Random random = new Random();
    private static int nextTicketNumber = 1001;

    // "static block": runs once, the first time DataStore is used -> sample matches
    static {
        Match derby = new Match("Simba SC", "Young Africans", "Benjamin Mkapa Stadium", "Today 16:00",
                15000, 50000, 120, Match.LIVE, 52);
        derby.homeScore = 1;
        derby.awayScore = 1;
        matches.add(derby);

        matches.add(new Match("Azam FC", "Singida Black Stars", "Azam Complex", "Sat 16:00",
                10000, 30000, 60, Match.UPCOMING, 0));
        matches.add(new Match("Dodoma Jiji", "Tanzania Prisons", "Jamhuri Stadium, Dodoma", "Sun 14:00",
                5000, 20000, 25, Match.UPCOMING, 0));

        Match finished = new Match("Coastal Union", "KMC FC", "Mkwakwani Stadium", "Yesterday",
                5000, 15000, 0, Match.FULL_TIME, 90);
        finished.homeScore = 2;
        finished.awayScore = 0;
        matches.add(finished);
    }

    /** Called every 2 seconds by the visible screen: fakes a live match and other fans buying seats. */
    public static void updateLiveMatches() {
        for (int i = 0; i < matches.size(); i++) {
            Match m = matches.get(i);

            if (m.status.equals(Match.LIVE)) {
                m.minute = m.minute + 1;
                if (random.nextInt(100) < 8) {          // 8% chance of a goal each tick
                    if (random.nextBoolean()) {
                        m.homeScore++;
                    } else {
                        m.awayScore++;
                    }
                }
                if (m.minute >= 90) {
                    m.status = Match.FULL_TIME;
                }
            }

            // other fans buy 0-2 seats sometimes
            if (m.canBuy() && random.nextInt(100) < 30) {
                int sold = random.nextInt(3);
                m.seatsLeft = Math.max(0, m.seatsLeft - sold);
            }
        }
    }

    /** Saves a new ticket and takes the seats. Returns the saved ticket. */
    public static Ticket buyTicket(int matchIndex, String name, String phone, String type, int quantity, int total) {
        Match m = matches.get(matchIndex);
        m.seatsLeft = m.seatsLeft - quantity;

        String code = "TKT-" + nextTicketNumber;
        nextTicketNumber++;

        Ticket t = new Ticket(code, name, phone, m.getTitle(), type, quantity, total);
        tickets.add(t);
        return t;
    }

    public static int totalSpent() {
        int sum = 0;
        for (int i = 0; i < tickets.size(); i++) {
            sum = sum + tickets.get(i).total;
        }
        return sum;
    }

    /** 45000 -> "TSh 45,000" */
    public static String money(int amount) {
        return "TSh " + String.format(Locale.US, "%,d", amount);
    }
}
