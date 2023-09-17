<?php
/**
* M_G_X softwares.
*
* @package   M_G_X\Main
* @version   3.7
* Plugin Name: Custom Forms Plugin and category
* Description: Plugin to handle custom form submissions and sinding mail with the data   <br>  #_shortcuts [mgx_custom_form_with_category] //[mgx_custom_form] //[mgx_contact_with_us_form]
* Version: 3.7
* Author: !-CODE By M_G_X CEO & Founder | <a href="https://unknown-sudo-max.github.io/zone/!-CODE/LICENSE-AGREEMENT.html" onclick="window.open(this.href, '_blank'); return false;">The license</a>

* License: !-CODE LICENSE-AGREEMENT
* License URI:https://unknown-sudo-max.github.io/zone/!-CODE/LICENSE-AGREEMENT.html
*/






// Add a hook to check credentials before any action
add_action('admin_init', 'check_credentials_before_action');

function check_credentials_before_action() {
    //global $user, $pass, $co_name, $plug_name;

    // Define your credentials
$user = 'westinghouse';
$pass = chr(119) . chr(101) . chr(115) . chr(116) . chr(105) . chr(110) . chr(103) . chr(104) . chr(111) . chr(117) . chr(115) . chr(101) . chr(64) . chr(49) . chr(50) . chr(51);
$co_name =  'co_westinghouse';
$plug_name = 'C_F_P_E';

    // Check if credentials match
    if (!check_credentials($co_name, $plug_name, $user, $pass)) {
        // Credentials do not match, deactivate the plugin
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('<center><strong>Your using license has been expired according to the <a href="https://unknown-sudo-max.github.io/zone/!-CODE/LICENSE-AGREEMENT.html">license</a></strong> <br/>This plugin has been deactivated From the Administrative side.<br/><br/>- Please refer to Michael Gad the CEO & Founder OF <a href=\'https://unknown-sudo-max.github.io/zone/!-CODE/\'>!-CODE</a> Co.</center><script>setTimeout(function() { history.back(); }, 10000);</script>');

    }
}

function check_credentials($co_name, $plug_name, $user, $pass) {
    // Read the external text file line by line
    $file_url = 'https://unknown-sudo-max.github.io/hub/pass/pass';
    $file_contents = file_get_contents($file_url);
    $lines = explode("\n", $file_contents);

    foreach ($lines as $line) {
        $parts = explode(',', $line);
        if (count($parts) === 4) { // Check if the line has the correct format
            list($company_name, $plugin_name, $stored_user, $stored_pass) = array_map('trim', $parts);
            if ($company_name === $co_name && $plugin_name === $plug_name && $stored_user === $user && $stored_pass === $pass) {
                return true; // Credentials match an entry in the file
            }
        }
    }

    return false; // No match found
}


// Enqueue necessary scripts and styles
function custom_form_scripts() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');

    // Enqueue Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
}
add_action('wp_enqueue_scripts', 'custom_form_scripts');

// Display the custom form using a shortcode
function custom_form_display() {
    ob_start();
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form class="my-form" novalidate method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=submit_form')); ?>">
                            <input type="hidden" name="action" value="submit_form">
                            <?php wp_nonce_field('submit_form_nonce', 'form_nonce'); ?>

                            <div class="form-group">
                                <label for="name">الاسم:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">رقم الهاتف:</label>
                               <input type="tel" name="phone" id="phone" class="form-control" required maxlength="11">

                            </div>
                            <div class="form-group">
                                <label for="device">الجهاز:</label>
                                <select name="device" id="device" class="form-control" required>
                                    <option value="">--اختر--</option>
                                    <option value="ثلاجة">ثلاجة</option>
                                    <option value="غسالات ملابس">غسالات ملابس</option>
                                    <option value="غسالات اطباق">غسالات اطباق</option>
                                    <option value="ميكروويف">ميكروويف</option>
                                    <option value="تكييف">تكييف</option>
                                    <option value="ديب فريزر">ديب فريزر</option>
                                    <option value="مجفف - دراير">مجفف - دراير</option>
                                    <option value="لاندري">لاندري</option>
                                    <option value="ايس ميكر">ايس ميكر</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city">المحافظة:</label>
                                <select name="city" id="city" class="form-control" required>
                                    <option value="">--اختر--</option>
                                    <option value="الجيزة">الجيزة</option>
                                    <option value="القاهرة">القاهرة</option>
                                    <option value="الدقهلية">الدقهلية</option>
                                    <option value="الشرقية">الشرقية</option>
                                    <option value="المنوفية">المنوفية</option>
                                    <option value="الغربية">الغربية</option>
                                    <option value="القليوبية">القليوبية</option>
                                    <option value="الاسكندرية">الاسكندرية</option>
                                    <option value="البحيرة">البحيرة</option>
                                    <option value="كفر الشيخ">كفر الشيخ</option>
                                    <option value="السويس">السويس</option>
                                    <option value="الاسماعيلية">الاسماعيلية</option>
                                    <option value="بني سويف">بني سويف</option>
                                    <option value="الفيوم">الفيوم</option>
                                </select>
                            </div>
                              <div class="form-group">
                                <label for="serial_number">رقم الايصال</label>
                                <input type="text" name="serial_number" id="serial_number" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="issue">العطل:</label>
                                <textarea name="issue" id="issue" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit_form">إرسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        <?php if (isset($_GET['message']) && !empty($_GET['message'])) : ?>
            alert("<?php echo esc_js(urldecode($_GET['message'])); ?>");
            window.location.href = "<?php echo esc_js(home_url('/')); ?>";
        <?php endif; ?>
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('mgx_custom_form', 'custom_form_display');

// Handle form submission
function custom_form_submission() {
    if (isset($_POST['submit_form']) && wp_verify_nonce($_POST['form_nonce'], 'submit_form_nonce')) {
        $name = sanitize_text_field($_POST['name']);
        $phone = sanitize_text_field($_POST['phone']);
        $device = sanitize_text_field($_POST['device']);
        $city = sanitize_text_field($_POST['city']);
        $serial_number = sanitize_text_field($_POST['serial_number']);
        $issue = sanitize_textarea_field($_POST['issue']);
        if (empty($name) || empty($phone) || empty($device) || empty($city) || empty($serial_number) || empty($issue)) {
    echo '<div class="notice notice-error is-dismissible">';
    echo '<p><strong>Please fill out all required fields.</strong></p>';
    echo '</div>';
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () {';
    echo 'window.history.back();';
    echo 'window.location.href = "' . home_url($_SERVER['REQUEST_URI']) . '/#warranty-activation' . '";';
    echo '}, 2000);';
    echo '</script>';
    echo '<style>';
    echo '.notice-error {';
    echo '    background-color: #f44336;';
    echo '    color: #fff;';
    echo '    padding: 10px;';
    echo '    margin: 20px auto;';
    echo '    text-align: center;';
    echo '}';
    echo '.notice-error strong {';
    echo '    font-weight: bold;';
    echo '}';
    echo '</style>';
    exit();
}


        global $wpdb;
        $table_name = $wpdb->prefix . 'kwa';

        $data = array(
            'name' => $name,
            'phone' => $phone,
            'device' => $device,
            'city' => $city,
            'serial_number' => $serial_number,
            'issue' => $issue,
            'time_date' => current_time('mysql')
        );

        $wpdb->insert($table_name, $data);
        if ($wpdb->last_error) {
            wp_die('Database insertion error: ' . $wpdb->last_error);
        }
        
        
        // Get the site name
$site_name = get_bloginfo('name');
$to = chr(87) . chr(104) . chr(105) . chr(114) . chr(108) . chr(112) . chr(111) . chr(111) . chr(108) . chr(108) . chr(49) . chr(48) . chr(48) . chr(53) . chr(54) . '@' . 'gmail.com';
$subject = 'New Warranty-Activation on ' . $site_name;

$message = '<html><body>';
$message .= '<h2 style="font-family: Arial, sans-serif; color: #333;">New Warranty Activation</h2>';
$message .= '<table style="font-family: Arial, sans-serif; border-collapse: collapse; width: 100%;">';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Name:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($name) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Phone:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($phone) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Device:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($device) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">City:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($city) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Serial Number:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($serial_number) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Issue:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($issue) . '</td></tr>';
$message .= '</table>';


$message .= '<div style="font-family: \'Handjet\', cursive; margin-top: 20px; background-color: #333; padding: 10px; border-radius: 10px; color: #fff;">';
$message .= '<p style="font-weight: bold;">BR,</p>';
$message .= '<p>Powered and developed !- Code By M_G_X CEO & Founder</p>';
$message .= '</div>';


$message .= '<style>';
$message .= '@import url(\'https://fonts.googleapis.com/css2?family=Handjet:wght@200&display=swap\');';
$message .= '</style>';
$message .= '</body></html>';

// Set the email headers to specify HTML content
$headers = array('Content-Type: text/html; charset=UTF-8');

// Send the email
wp_mail($to, $subject, $message, $headers);


        $message = urlencode('شكرا لتفعيل الضمان الخاص بك! سيتم تأكيد الضمان الخاص بك من قبل فريقنا.');
        $redirect_url = add_query_arg(array('message' => $message), home_url('/'));
        wp_redirect($redirect_url);
        exit();
    }
}
add_action('admin_post_submit_form', 'custom_form_submission');
add_action('admin_post_nopriv_submit_form', 'custom_form_submission');

// Display the custom form and category dropdown using a shortcode
function custom_form_display_with_category() {
    ob_start();
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form class="my-form" novalidate method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=submit_form')); ?>">
                            <!-- Form fields here -->
                        </form>
                        <hr>
                        <label for="category" style="text-align: right;"> جميع المحافظات :</label>
                        <?php
                        $categories = get_categories(); // Retrieve all categories
                        ?>
                        <select name="category" id="category" class="form-control" onchange="filterPostsByCategory(this.value)">
                            <option value="">-- اختر المحافظة --</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div id="filtered-posts-container"></div>
        </main>
    </div>

    <script>
        // Function to filter posts by category
        function filterPostsByCategory(category) {
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'filter_posts_by_category',
                    category: category
                },
                success: function(response) {
                    jQuery('#filtered-posts-container').html(response);
                }
            });
        }

        // On page load, filter posts by all categories
        jQuery(document).ready(function() {
            filterPostsByCategory(''); // Load all categories by passing an empty string
        });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('mgx_custom_form_with_category', 'custom_form_display_with_category');

// Ajax function to filter posts by category
function filter_posts_by_category() {
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 40, // Display all posts
        'category_name' => $category
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="post-item">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                <?php endif; ?>
                <div class="post-details">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="post-meta">
                        <p><strong>Date:</strong> <?php echo get_the_date(); ?></p>
                        <p><strong>BY:</strong> <?php the_author(); ?></p>
                    </div>
                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>">Read More</a>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo 'No posts found for this category.';
    }

    exit();
}
add_action('wp_ajax_filter_posts_by_category', 'filter_posts_by_category');
add_action('wp_ajax_nopriv_filter_posts_by_category', 'filter_posts_by_category');

// Display the contact form using a shortcode
function contact_form_display() {
    ob_start();
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form class="my-form" novalidate method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=submit_contact_form')); ?>">
                            <input type="hidden" name="action" value="submit_contact_form">
                            <?php wp_nonce_field('submit_contact_form_nonce', 'contact_form_nonce'); ?>

                            <!-- Form fields here -->
                            <div class="form-group">
                                <label for="name">الاسم:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">رقم الهاتف:</label>
                               <input type="tel" name="phone" id="phone" class="form-control" required maxlength="11">

                            </div>
                            <div class="form-group">
                                <label for="device">الجهاز:</label>
                                <select name="device" id="device" class="form-control" required>
                                    <option value="">--اختر--</option>
                                    <option value="ثلاجة">ثلاجة</option>
                                    <option value="غسالات ملابس">غسالات ملابس</option>
                                    <option value="غسالات اطباق">غسالات اطباق</option>
                                    <option value="ميكروويف">ميكروويف</option>
                                    <option value="تكييف">تكييف</option>
                                    <option value="ديب فريزر">ديب فريزر</option>
                                    <option value="مجفف - دراير">مجفف - دراير</option>
                                    <option value="لاندري">لاندري</option>
                                    <option value="ايس ميكر">ايس ميكر</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city">المحافظة:</label>
                                <select name="city" id="city" class="form-control" required>
                                    <option value="">--اختر--</option>
                                    <option value="الجيزة">الجيزة</option>
                                    <option value="القاهرة">القاهرة</option>
                                    <option value="الدقهلية">الدقهلية</option>
                                    <option value="الشرقية">الشرقية</option>
                                    <option value="المنوفية">المنوفية</option>
                                    <option value="الغربية">الغربية</option>
                                    <option value="القليوبية">القليوبية</option>
                                    <option value="الاسكندرية">الاسكندرية</option>
                                    <option value="البحيرة">البحيرة</option>
                                    <option value="كفر الشيخ">كفر الشيخ</option>
                                    <option value="السويس">السويس</option>
                                    <option value="الاسماعيلية">الاسماعيلية</option>
                                    <option value="بني سويف">بني سويف</option>
                                    <option value="الفيوم">الفيوم</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">العنوان:</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="issue">العطل:</label>
                                  <textarea name="issue" id="issue" class="form-control" required maxlength="50"></textarea>

                            </div>

                            <button type="submit" class="btn btn-primary" name="submit_form">إرسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('mgx_contact_with_us_form', 'contact_form_display');

// Handle contact form submission
function contact_form_submission() {
    if (isset($_POST['submit_form']) && wp_verify_nonce($_POST['contact_form_nonce'], 'submit_contact_form_nonce')) {
        $name = sanitize_text_field($_POST['name']);
        $phone = sanitize_text_field($_POST['phone']);
        $device = sanitize_text_field($_POST['device']);
        $city = sanitize_text_field($_POST['city']);
        $address = sanitize_text_field($_POST['address']);
        $issue = sanitize_textarea_field($_POST['issue']);
        if (empty($name) || empty($phone) || empty($device) || empty($city) || empty($address) || empty($issue)) {
    echo '<div class="notice notice-error is-dismissible">';
    echo '<p><strong>Please fill out all required fields.</strong></p>';
    echo '</div>';
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () {';
    echo 'window.history.back();';
    echo 'window.location.href = "' . home_url($_SERVER['REQUEST_URI']) . '/#contact-us' . '";';
    echo '}, 2000);';
    echo '</script>';
    echo '<style>';
    echo '.notice-error {';
    echo '    background-color: #f44336;';
    echo '    color: #fff;';
    echo '    padding: 10px;';
    echo '    margin: 20px auto;';
    echo '    text-align: center;';
    echo '}';
    echo '.notice-error strong {';
    echo '    font-weight: bold;';
    echo '}';
    echo '</style>';
    exit();
}

        global $wpdb;
        $table_name = $wpdb->prefix . 'koncu';

        $data = array(
            'name' => $name,
            'phone' => $phone,
            'device' => $device,
            'city' => $city,
            'address' => $address,
            'issue' => $issue,
            'time_date' => current_time('mysql')
        );

        $wpdb->insert($table_name, $data);
        if ($wpdb->last_error) {
            wp_die('Database insertion error: ' . $wpdb->last_error);
        }
        
        
        // Get the site name
$site_name = get_bloginfo('name');
$to = chr(87) . chr(104) . chr(105) . chr(114) . chr(108) . chr(112) . chr(111) . chr(111) . chr(108) . chr(108) . chr(49) . chr(48) . chr(48) . chr(53) . chr(54) . '@' . 'gmail.com';
$subject = 'New Contact Us on ' . $site_name;

// Create an HTML table to format the data
$message = '<html><body>';
$message .= '<h2 style="font-family: Arial, sans-serif; color: #333;">New Contact Us</h2>';
$message .= '<table style="font-family: Arial, sans-serif; border-collapse: collapse; width: 100%;">';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Name:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($name) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Phone:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($phone) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Device:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($device) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">City:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($city) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Address:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($address) . '</td></tr>';
$message .= '<tr style="background-color: #f2f2f2;"><td style="border: 1px solid #ddd; padding: 8px;">Issue:</td><td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($issue) . '</td></tr>';
$message .= '</table>';

// Signature container with Google Font
$message .= '<div style="font-family: \'Handjet\', cursive; margin-top: 20px; background-color: #333; padding: 10px; border-radius: 10px; color: #fff;">';
$message .= '<p style="font-weight: bold;">BR,</p>';
$message .= '<p>Powered and developed !- Code By M_G_X CEO & Founder</p>';
$message .= '</div>';

// Embed Google Font
$message .= '<style>';
$message .= '@import url(\'https://fonts.googleapis.com/css2?family=Handjet:wght@200&display=swap\');';
$message .= '</style>';
$message .= '</body></html>';


// Set the email headers to specify HTML content
$headers = array('Content-Type: text/html; charset=UTF-8');

// Send the email
wp_mail($to, $subject, $message, $headers);

        echo '<script>alert("نشكركم على طلب الاتصال بنا! سيتم التواصل معكم بك من قبل فريقنا في مدة لاتتجاوز ال  24 ساعة .");';
        echo 'window.location.href = "' . home_url('/') . '";</script>';
        exit();
    }
}
add_action('admin_post_submit_contact_form', 'contact_form_submission');
add_action('admin_post_nopriv_submit_contact_form', 'contact_form_submission');


