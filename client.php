<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of client
 *
 * @author eshan
 */
include("connect.php");

class client {

    public $c;
    public $conn;

    public function __construct() {
        $this->c = new connect();
        $this->conn = $this->c->con();
    }

    public function submit($name, $pass, $phone, $address, $mail) {
        if (!self::exists($name) && !self::existsMail($mail) && !self::exists($phone)) {
            $query1 = "Insert into login values('" . $name . "','" . $pass . "','1');";
            $query2 = "Insert into customer values(NULL,'" . $name . "','" . $phone . "','" . $address . "','" . $mail . "',0);";
            //echo $query2;
            $r = $this->c->insert($this->conn, $query1);
            $s = $this->c->insert($this->conn, $query2);
            return true;
        }
        return false;
    }

    public function exists($name) {
        $query = "Select Name from login where Name='" . $name . "';";
        $result = $this->c->execute($this->conn, $query);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public function existsMail($mail) {
        $query = "Select mail from customer where mail='" . $mail . "';";
        $result = $this->c->execute($this->conn, $query);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public function existsPhone($phone) {
        $query = "Select phone from customer where phone='" . $phone . "';";
        $result = $this->c->execute($this->conn, $query);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public function getName($id) {
        $query = "Select name from customer where id='" . $id . "';";
        $result = $this->c->execute($this->conn, $query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["name"];
        }
        return 0;
    }

    public function details($name) {
        if (self::exists($name)) {
            $query = "Select * from customer where Name='" . $name . "';";
            $result = $this->c->execute($this->conn, $query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\"> " . "ID : " . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["id"] . "</td></br>";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\"> " . "Name : " . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["name"] . "</td></br>";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\"> " . "Phone : " . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["phone"] . "</td></br>";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\"> " . "Address : " . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["address"] . "</td></br>";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\"> " . "Email : " . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["mail"] . "</td></br>";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\"> " . "Booked : " . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["booked"] . "</td></br>";
                echo "</tr>\n";
            }
        }
    }

    public function getSchedule($source, $destination) {
        $_SESSION["schedule"] = NULL;
        $query = "Select * from route,schedule,station,train where route.source=\"" . $source . "\" and route.destination=\"" . $destination . "\" and route.id=schedule.RouteNo and schedule.station=station.id and schedule.trainNo=train.no and train.freeSeat>0;";
        $result = $this->c->execute($this->conn, $query);
        echo "<tr>\n";
        echo "<td style=\"border:1px solid black;\"> " . "Train Name" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Source" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Arrival time" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Departure time" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Station" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Free seats" . "</td>";
        echo "</tr>\n";
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\">" . '<a href="details.php?name=' . $row["name"] . '&schedule=' . $row["ScheduleNo"] . '">' . " " . $row["trainName"] . "</a></td>" . "<td style=\"border:1px solid black;\"> " . $row["Location"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["Arrival"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["Departure"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["name"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["freeSeat"] . "</td></br>";
                echo "</tr>\n";
            }
        } else {
            echo "0 results\n";
        }
    }

    public function getRawSchedule($source, $destination) {
        $_SESSION["schedule"] = NULL;
        $query = "Select * from route,schedule,station,train where route.source=\"" . $source . "\" and route.destination=\"" . $destination . "\" and route.id=schedule.RouteNo and schedule.station=station.id and schedule.trainNo=train.no and train.freeSeat>0;";
        $result = $this->c->execute($this->conn, $query);
        echo "<tr>\n";
        echo "<td style=\"border:1px solid black;\"> " . "Train Name" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Source" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Arrival time" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Departure time" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Station" . "</td>" . "<td style=\"border:1px solid black;\"> " . "Free seats" . "</td>";
        echo "</tr>\n";
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\">" . $row["trainName"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["Location"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["Arrival"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["Departure"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["name"] . "</td>" . "<td style=\"border:1px solid black;\"> " . $row["freeSeat"] . "</td></br>";
                echo "</tr>\n";
            }
        } else {
            echo "0 results\n";
        }
    }

    public function CheckBooking($schedule, $class, $seatAmounts) {
        $query = "Select COUNT(*) from seat where seat.empty=0 and seat.schedule='" . $schedule . "' and seat.ClassNo='" . $class . "';";
        //echo $query;
        $result = $this->c->execute($this->conn, $query);
        $row = $result->fetch_assoc();
        // echo $row["COUNT(*)"]." ".$seatAmounts;
        if ((int) $row["COUNT(*)"] >= $seatAmounts) {
            $query = "Select TicketPrice from class where classNo='" . $class . "';";
            $result = $this->c->execute($this->conn, $query);
            $r = $result->fetch_assoc();
            echo "Total Cost : " . $seatAmounts * $r["TicketPrice"] . "</br>";
            return $seatAmounts * $r["TicketPrice"];
        } else {
            echo "Not enought seats </br>";
            return -1;
        }
    }

    public function makeBooking($schedule, $class, $seatAmounts, $date, $user) {
        $query = "Select booked from customer where id=" . $user . ";";
        $result = $this->c->execute($this->conn, $query);
        $row = $result->fetch_assoc();
        if ((int) $row["booked"] < 6) {
            $query = "Select COUNT(*) from seat where seat.empty=0 and seat.schedule='" . $schedule . "' and seat.ClassNo='" . $class . "';";
            $result = $this->c->execute($this->conn, $query);
            $row = $result->fetch_assoc();
            $cost = self::checkBooking($schedule, $class, $seatAmounts);
            if ((int) $row["COUNT(*)"] >= $seatAmounts) {
                $count = 0;
                while ($count < $seatAmounts) {
                    self::booking($schedule, $class, $cost, $date, $user);
                    $count++;
                }
                $query = "Update customer set booked=booked+" . $seatAmounts . " where id=" . $user . ";";
                $this->c->insert($this->conn, $query);
                echo "Booking Made </br>";
                self::sendMail($user, "Booking made");
            }
        } else {
            echo "Booking Limit Exceeded";
        }
    }

    public function booking($schedule, $class, $cost, $date, $user) {
        $query = "Select * from seat,schedule,class where schedule.ScheduleNo=" . $schedule . " and schedule.ScheduleNo=seat.schedule and seat.empty=0 and class.classNo='" . $class . "' and class.classNo=seat.ClassNo;";
        ;
        //echo $query;
        $result = $this->c->execute($this->conn, $query);
        if ($cost != -1) {
            $row = $result->fetch_assoc();
            $query = "Insert into booking values(NULL,'" . $date . "','" . $row["SeatNo"] . "','" . $user . "','0','" . $row["ScheduleNo"] . "');";
            //echo $query;
            $this->c->insert($this->conn, $query);
            $query = "Update seat set empty=1 where SeatNo='" . $row["SeatNo"] . "';";
            $this->c->insert($this->conn, $query);
            $query = "Update train set freeSeat=freeSeat-1 where no='" . $row["trainNo"] . "' and freeSeat>0 ;";
            $this->c->insert($this->conn, $query);
            $query = "Insert into payment values '" . $user . "','" . $cost . "';";
            $this->c->insert($this->conn, $query);
            self::issueTicket($row["SeatNo"]);
        } else {
            echo "Not enought </br>";
        }
    }

    public function issueTicket($seat) {
        $query = "Select ID from booking where seat_no='" . $seat . "';";
        $result = $this->c->execute($this->conn, $query);
        $row = $result->fetch_assoc();
        $query = "Insert into ticket values(NULL," . $row["ID"] . ");";
        $this->c->insert($this->conn, $query);
    }

    public function sendMail($id, $string) {
        $query = "Select mail from customer where id=" . $id . ";";
        $result = $this->c->execute($this->conn, $query);
        $row = $result->fetch_assoc();
        $mail = "\"" . $row["mail"] . "\"";
        if (mail($mail, 'Booking Made', $string)) {
            echo "done";
        }
    }

    public function listBookings($id) {
        $query = "Select * from booking,schedule,route,train,class,seat,payment where booking.customerNo=" . $id . " and booking.ScheduleNo=schedule.ScheduleNo and schedule.routeNo=route.id and schedule.trainNo=train.no and booking.seat_no=seat.SeatNo and seat.ClassNo=class.classNo and payment.customerNo=booking.customerNo;";
        $result = $this->c->execute($this->conn, $query);
        if ($result->num_rows > 0) {
            echo "<table style=\"border:1px solid black; border-collapse:collapse;\" width=\"1350\"> \n";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\">" . $row["date"] . "</td>" . " " . "<td style=\"border:1px solid black;\">" . $row["seat_no"] . "</td>" . " " . "<td style=\"border:1px solid black;\">" . $row["trainName"] . "</td>" . "<td style=\"border:1px solid black;\">" . $row["Arrival"] . "</td>" . " " . "<td style=\"border:1px solid black;\">" . $row["Departure"] . "</td>" . " " . "<td style=\"border:1px solid black;\">" . $row["source"] . "</td>" . " " . "<td style=\"border:1px solid black;\">" . $row["destination"] . "</td>" . " " . "<td style=\"border:1px solid black;\">" . $row["ClassName"] . "</td>" . " " . "<td style=\"border:1px solid black;\">" . $row["TicketPrice"] . "</td>" . "</br>";
                echo "</tr>\n";
            }
        }
    }

    public function listNotice($id) {
        $query = "Select * from booking,Notice where booking.customerNo='" . $id . "' and booking.ScheduleNo=Notice.ScheduleNo;";
        //echo $query;
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            echo "<table style=\"border:1px solid black; border-collapse:collapse;\" width=\"1350\"> \n";
            echo "<td style=\"border:1px solid black;\">" . "Notice" . "</td>" . "<br>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>\n";
                echo "<td style=\"border:1px solid black;\">" . $row["Notice"] . "</td>" . "<br>";
                echo "</tr>\n";
            }
        }
    }

}
