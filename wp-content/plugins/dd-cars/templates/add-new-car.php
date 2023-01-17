<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- //jquery// -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js"></script>

    <title>Add New Car</title>
</head>

<body>
    <h1>Add New Car</h1>

    <?php

    function handle_logo_upload($file)
    {

        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploadedfile = $file;

        $movefile = wp_handle_upload($uploadedfile, array('test_form' => false));

        if ($movefile) {

            //or return
            return $movefile['url'];
        }
    }
    function createSlug($str, $delimiter = '-')
    {

        $unwanted_array = [
            'ś' => 's', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z',
            'Ś' => 's', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z'
        ]; // Polish letters for example
        $str = strtr($str, $unwanted_array);

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

    if (isset($_POST['addCar'])) {
        $car_title = $_POST['car_title'];
        $car_year = $_POST['car_year'];
        $car_price = $_POST['car_price'];
        $car_gear_type = $_POST['car_gear_type'];
        $car_mileage = $_POST['car_mileage'];
        $car_fuel_type = $_POST['car_fuel_type'];
        $car_displacement = $_POST['car_displacement'];


        $car_image = handle_logo_upload($_FILES['car_image']);


        global $wpdb;

        $sql = $wpdb->prepare(
            "INSERT INTO `tbl_addnewcar` (`car_title`, `car_image`, `car_year`, `car_price`, `car_gear_type`, `car_mileage`, `car_fuel_type`, `car_displacement`)
            values ('$car_title', '$car_image', $car_year, $car_price, '$car_gear_type', $car_mileage, '$car_fuel_type', $car_displacement)"
        );

        $wpdb->query($sql);

        if ($sql == true) {
            echo "<script>alert('Data inserted')</script>";
        } else {
            echo "<script>alert('Data not inserted')</script>";
        }
    }


    ?>

    <form role="form" method="POST" action="" enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Enter Your Title" name="car_title">
            <label for="floatingInput">Title</label>
        </div>


        <input class="form-control" type="file" name="car_image">
        <label for="floatingInput">Add Image</label>


        <div class="form-floating mb-3">
            <input class="form-control" type="number" name="car_year">
            <label for="floatingInput">Year</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="number" name="car_price">
            <label for="floatingInput">Price</label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select" name="car_gear_type" require>
                <option selected disabled>Gear Type</option>
                <option value="Auto">Auto</option>
                <option value="Manual">Manual</option>
            </select>
            <label for="floatingInput">Gear Type</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="number" name="car_mileage">
            <label for="floatingInput">Mileage</label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select" name="car_fuel_type" require>
                <option selected disabled>Fuel Type</option>
                <option value="Petrol">Petrol</option>
                <option value="CNG">CNG</option>
                <option value="Diesel">Diesel</option>
            </select>
            <label for="floatingInput">Fuel Type</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="number" name="car_displacement">
            <label for="floatingInput">Displacement</label>
        </div>

        <div class="form-floating mb-3">
            <input type="submit" class="btn btn-primary mb-3" value="submit" name="addCar" />

        </div>
    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>