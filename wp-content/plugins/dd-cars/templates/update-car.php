<?php
/* Template Name: Car Update Page */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/dd-wheels/wp-content/plugins/dd-cars/templates/dd-cars-overview.css" rel="stylesheet">
    <title>Cars Overview</title>
</head>

<body>

    <h1>Cars Overview Page</h1>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-image">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Featured Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Year</th>
                            <th scope="col">Price</th>
                            <th scope="col">Gear Type</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        //Query to get all the data from list inventory table
                        global $wpdb;

                        $cars = $wpdb->get_results("SELECT * From `tbl_addnewcar`");

                        foreach ($cars as $car) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $car->id; ?></th>
                                <td class="w-25">

                                    <img src="<?php echo $car->car_image; ?>" class="img-fluid img-thumbnail" alt="Sheep">
                                </td>
                                <td><?php echo $car->car_title; ?></td>
                                <td><?php echo $car->car_year; ?></td>
                                <td><?php echo $car->car_price; ?></td>
                                <td><?php echo $car->car_gear_type; ?></td>
                                <td>

                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu">
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?php echo $car->id; ?>" />
                                                <a class="dropdown-item" name="update" href="<?php echo get_site_url(); ?>/update-car?id=<?php echo $car->id; ?>">Update</a>
                                            </form>
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?php echo $car->id; ?>" />
                                                <li class="dropdown-item" name="delete" value="<?php echo $car->id; ?>">Delete</li>
                                            </form>
                                        </ul>
                                    </div>


                                </td>

                            </tr>
                        <?php

                        }
                        if (isset($_POST['update'])) {
                            //     echo "Button is Clicked";
                            $id = $_POST['id'];
                            $car_title = $_POST['car_title'];
                            $car_year = $_POST['car_year'];
                            $car_price = $_POST['car_price'];
                            $car_gear_type = $_POST['car_gear_type'];
                            $car_mileage = $_POST['car_mileage'];
                            $car_fuel_type = $_POST['car_fuel_type'];
                            $car_displacement = $_POST['car_displacement'];

                            global $wpdb;
                            $sql = $wpdb->prepare(
                                "UPDATE `tbl_addnewcar` (`car_title`, `car_image`, `car_year`, `car_price`, `car_gear_type`, `car_mileage`, `car_fuel_type`, `car_displacement`)
                                values ('$car_title', '$car_image', $car_year, $car_price, '$car_gear_type', $car_mileage, '$car_fuel_type', $car_displacement) WHERE $id='id' "
                            );

                            $result = $wpdb->query($sql);
                            echo $result;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>