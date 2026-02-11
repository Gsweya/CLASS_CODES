#! /bin/bash
read -p "Enter the name of the car brand: " car

case $car in
    Tesla)
        echo "${car}'s car factory is in the USA."
        ;;
    BMW | Mercedes | Audi | Porsche)
        echo "${car}'s factory is in Germany."
        ;;
    *)
        echo "No idea where ${car} is made. Either it's obscure or you misspelled it."
        ;;
esac
