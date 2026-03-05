abstract class GardenDevice {

    public void turnOn(){

    }

    public abstract void adjustFlow();



}

class BasicSprinkler extends GardenDevice {

    @Override
    public void adjustFlow(){
        System.out.println("new Flow");
    }

    
}

class SmartSensorSprinkler extends GardenDevice {

    @Override
    public void adjustFlow(){
        System.out.println("Old flow");
    }

    
}


public class Demo {


}