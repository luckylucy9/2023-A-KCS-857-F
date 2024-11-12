!DOCTYPE html
html lang=en
head
    meta charset=UTF-8
    meta name=viewport content=width=device-width, initial-scale=1.0
    titleCar Rental Managementtitle
    !-- Bootstrap CSS --
    link href=httpsstackpath.bootstrapcdn.combootstrap4.5.2cssbootstrap.min.css rel=stylesheet
head
body

div class=container mt-4
    h2 class=text-centerCar Rental Systemh2
    div class=row
        !-- Fetch and display cars --
        php
        $conn = new mysqli('localhost', 'root', '', 'car_rental');  Database connection
        if ($conn-connect_error) {
            die(Connection failed  . $conn-connect_error);
        }

        $sql = SELECT  FROM cars WHERE available = 1;
        $result = $conn-query($sql);

        if ($result-num_rows  0) {
            while ($car = $result-fetch_assoc()) {
                echo 'div class=col-md-4 mb-4
                        div class=card
                            img class=card-img-top src=car-image.jpg alt=Car Image
                            div class=card-body
                                h5 class=card-title' . $car['car_name'] . ' (' . $car['car_model'] . ')h5
                                p class=card-textPrice $' . $car['car_price'] . ' per dayp
                                a href=rent.phpcar_id=' . $car['car_id'] . ' class=btn btn-primaryRent this Cara
                            div
                        div
                    div';
            }
        } else {
            echo pNo cars available for rent at the moment.p;
        }

        $conn-close();
        
    div
div

!-- Bootstrap JS, Popper.js, and jQuery --
script src=httpscode.jquery.comjquery-3.5.1.slim.min.jsscript
script src=httpscdn.jsdelivr.netnpm@popperjscore@2.5.4distumdpopper.min.jsscript
script src=httpsstackpath.bootstrapcdn.combootstrap4.5.2jsbootstrap.min.jsscript

body
html
