@Override
    public double getWaterUsage() {
        return isActive ? flowRate : 0.0;
    }
