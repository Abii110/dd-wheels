<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/dd-wheels/wp-content/plugins/dd-cars/templates/dd-cars-overview.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js"></script>
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
                            <tr id="car<?php echo $car->id ?>">
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
                                            <li>
                                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#update_modal<?php echo $car->id; ?>">Edit</button>
                                            </li>
                                            <li>
                                                <form method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $car->id; ?>" />
                                                    <button class="dropdown-item" type="submit" name="delete" value="<?php echo $car->id; ?>">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>


                                </td>

                            </tr>
                            <!-- Update Car Modal -->
                            <input type="hidden" name="id" value="<?php echo $car->id; ?>" />
                            <div class="modal fade" id="update_modal<?php echo $car->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php

                        }

                        if (isset($_POST['delete'])) {
                            $id = $_POST['id'];
                            $wpdb->delete('tbl_addnewcar', array('id' => $id));
                            echo '<script>
                            document.getElementById("car' . $id . '").remove();
                            </script>';
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


<?php
function myfunction1($post)
{
    $url = get_post_permalink($post->ID);
    $title =  $post->post_title;
    $excerpt =  $post->post_excerpt;
    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
    return '

                
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="' . $featured_image[0] . '"
                                alt="">
                            <a href="' . $url . '" class="over-layer"></a>
                        </div>
                        <div class="post-content">
                            <h3 class="post-title">
                                <a href="' . $url . '">' . $title . '</a>
                            </h3>
                            <p class="post-description">' . $excerpt . '</p>
                        </div>
                    </div>
                
			
	';
}
function case_link()
{
    $args = array("posts_per_page" => 3, "category_name" => "crime");
    $posts_array = get_posts($args);
    $case_inner = array_map("myfunction1", $posts_array);
    return  '   

		 			    <div class="container">
        <div class="row news-slider-row">
            <div class="col-md-12">
			<div id="news-slider" class="owl-carousel">
			
            ' . implode(" ", $case_inner) . '
			
			</div>
       </div>
      </div>
    </div>
					';
}

add_shortcode('case', 'case_link');

?>