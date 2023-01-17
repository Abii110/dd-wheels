<?php

/**
 * @package DesignerDevCarsPlugin
 */
/*
Plugin Name: Designer Dev Cars Plugin
Plugin URI: https://www.designer-dev.com/
Description: Nulla facilisi. In porta tortor rutrum arcu tincidunt, sit amet elementum metus imperdiet. Nam ac nisl imperdiet, facilisis risus eget, mattis tortor.
Version: 1.0.0
Author: Designer-Dev
Author URI: https://www.designer-dev.com/
License: GPLv2 or later
Text Domain: dd-cars-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined('ABSPATH') or die('You Cannot Access The File. SORRY!');

class dd_cars
{


    function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_pages'));
    }
    public function add_admin_pages()
    {
        add_menu_page('DD Cars', 'DD Cars', 'manage_options', 'dd_cars', array($this, 'admin_index'), 'dashicons-car', 2);
        add_submenu_page('dd_cars', 'car_category', 'Category', 'manage_options', 'car_category', array($this, 'category_page'));
        add_submenu_page('dd_cars', 'add_new_car', 'Add New Car', 'manage_options', 'add_new_car', array($this, 'add_new_car_page'));
    }

    public function admin_index()
    {
        require_once plugin_dir_path(__FILE__) . 'templates/dd-cars-overview.php';
    }
    public function add_new_car_page()
    {
        require_once plugin_dir_path(__FILE__) . 'templates/add-new-car.php';
    }
    public function category_page()
    {
        require_once plugin_dir_path(__FILE__) . 'templates/car-categories.php';
    }

    function activate()
    {
        // generated a CPT
        // flush rewrite rules
        flush_rewrite_rules();
    }
    function deactivate()
    {
        // flush rewrite rules
        flush_rewrite_rules();
    }
    function uninstall()
    {
        // delete CPT
        // delete all the plugins data from DB
    }
}

if (class_exists('dd_cars')) {
    $dd_cars = new dd_cars();
}

//Activation
register_activation_hook(__FILE__, array($dd_cars, 'activate'));

//Deactivation
register_activation_hook(__FILE__, array($dd_cars, 'deactivate'));

//Uninstall


function featured_cars($cars)
{
    return '

                
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="' . $cars->car_title . '"
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
function feature_car_inner()
{

    global $wpdb;

    $cars = $wpdb->get_results("SELECT * From `tbl_addnewcar`");
    $featured_inner = array_map("featured_cars", $cars);
    return  '   
    <style>
    .card{
      background: #FFFFFF;
box-shadow: 0px 1px 4px rgba(108, 108, 108, 0.251912);
border-radius: 4px;  
    }
        .card-body {
            position: relative;
        }

        .card-img-overlay {
            position: absolute;
            top: auto;
            right: auto;
            bottom: 0;
            left: auto;
            padding: var(--bs-card-img-overlay-padding);
            border-radius: var(--bs-card-inner-border-radius);
        }

        .price {
            background-color: #B20017;
            color: #fff;
            padding: 8.5px;
            font-family: "Lato";
            font-style: normal;
            font-weight: 700;
            font-size: 14px;
            line-height: 17px;
            text-align: center;
            border-radius: 4px;
        }

        .card-img {
            border-radius: 0;
        }

        .pr-title {
            font-family: "Goldman";
            font-style: normal;
            font-weight: 400;
            font-size: 18px;
            line-height: 24px;
            color: #181819;
            padding:20px 10px;
        }

        .pr-types-box {
            border-right: 1px solid #D8D8D8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        p.pr-types {
            font-size: 12px;
            text-align: center;
            margin: 0;
        }

        .tabs {
            justify-content: center;
            background-color: transparent;
            color: #B20017;
            border: none;
            padding: 20px 0;
        }

        .nav-link .active {
            background-color: transparent;
            color: #B20017;
        }

        .nav-link:focus,
        .nav-link:hover {
            color: #B20017;
        }

        .nav-link {
            background-color: transparent;
            color: #181819;
            border: none;
            font-family: "Lato";
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            line-height: 24px;
            /* identical to box height */

            text-align: center;
        }
        .card-footer{
            padding: 20px 0;
        }
    </style>
		 			    
			
            ' . implode(" ", $featured_inner) . '
			
			
					';
}

add_shortcode('featured cars', 'feature_car_inner');
