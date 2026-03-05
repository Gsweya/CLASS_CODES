package test_2026_code;

 interface Controllable {
    void turnOn();
    void turnOff();
    double getWaterUsage();   // liters per hour

    default void emergencyStop() {
        System.out.println("Emergency stop activated!");
    }
}

abstract class GardenDevice implements Controllable {

    protected String deviceId;
    protected boolean isActive = false;

    public GardenDevice(String deviceId) {
        this.deviceId = deviceId;
    }

    public void turnOn() {
        isActive = true;
        System.out.println(deviceId + " is now watering.");
    }

    public void turnOff() {
        isActive = false;
        System.out.println(deviceId + " stopped watering.");
    }

    public abstract void adjustFlow(double litersPerHour);
}

class BasicSprinkler extends GardenDevice {

    private double flowRate = 10.0;

    public BasicSprinkler(String id) {
        super(id);
    }

    @Override
    public double getWaterUsage() {
        return isActive ? flowRate : 0.0;
    }

    @Override
    public void adjustFlow(double litersPerHour) {
        flowRate = litersPerHour;
    }
}

class SmartSensorSprinkler extends BasicSprinkler {

    private boolean rainSensor;

    public SmartSensorSprinkler(String id) {
        super(id);
    }

    
    

    public void setRainSensor(boolean status) {
        rainSensor = status;
    }
}

public class GardenTest {
    public static void main(String[] args) {

        GardenDevice d1 = new BasicSprinkler("SP-001");
        GardenDevice d2 = new SmartSensorSprinkler("SNS-002");

        d1.turnOn();
        d1.adjustFlow(15.0);
        System.out.println(d1.getWaterUsage());

        d2.turnOn();
        d2.adjustFlow(18.0);

        if (d2 instanceof SmartSensorSprinkler) {
            SmartSensorSprinkler smart =
                    (SmartSensorSprinkler) d2;

 

            smart.setRainSensor(true);
            smart.adjustFlow(20);
            smart.turnOff();
        }
    }
} {
    
}
