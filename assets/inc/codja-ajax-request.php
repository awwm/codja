<?php
/*
*
*	***** CODJA *****
*
*	Ajax Request
*	
*/
// If this file is called directly, abort. //
if (!defined('WPINC')) {
    die;
} // end if
/*
Ajax Requests
*/

add_action('wp_ajax_codja_users_frontend_ajax', 'codja_users_list_frontend_ajax');
add_action('wp_ajax_nopriv_codja_users_frontend_ajax', 'codja_users_list_frontend_ajax');
function codja_users_list_frontend_ajax()
{
    global $wpdb;
    // Set default variables
    $msg = '';
    if (isset($_POST['page']) || isset($_POST['role'])) {
        // Sanitize the received page   
        $page = sanitize_text_field($_POST['page']);
        $role = sanitize_text_field($_POST['role']);

        if(!empty($role)) {
            $arr_role = explode(',', $role);
        } else {
            $arr_role = explode(',', 'author,contributor,editor,subscriber');
        }

        $cur_page = $page;
        $page -= 1;
        $per_page = 10; //set the per page limit
        $previous_btn = true;
        $next_btn = true;
        $start = $page * $per_page;
        $orderby = (!empty($_POST['orderby']) ? $_POST['orderby'] : '');
        $order = (!empty($_POST['order']) ? $_POST['order'] : '');
        $all_users = new WP_User_Query(
            array(
                'role__in' => $arr_role,
                'orderby'      => $orderby,
                'order'        => $order,
                'number'       => $per_page,
                'offset'       => $start
            )
        );

        $count = $all_users->get_total();
        $allusers_list = $all_users->get_results(); ?>
        <div class="row">
            <div class="col-12 text-end mb-3">
                <?php global $wp_roles; ?>
                <select name="role">
                    <option value=''>Filter By User Roles</option>
                    <?php foreach ( $wp_roles->roles as $key=>$role ): ?>
                        <?php if ($key!='administrator') : ?>
                            <option value="<?php echo $key; ?>" <?= (isset($_POST['role']) && $_POST['role'] == $key) ? 'selected' : '' ?>><?php echo $role['name']; ?></option>
                        <?php endif;?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php if (!empty($allusers_list)) { ?>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table align-middle users-list table-striped">
                            <thead>
                                <tr>
                                    <td class="sort_column" id="sort_by_id">User ID <span> <i class="fa fa-arrow-down-1-9"></i></span></td>
                                    <td class="sort_column" id="sort_by_name">User Name <span> <i class="fa fa-arrow-down-a-z"></i></span></td>
                                    <td class="sort_column" id="sort_by_email">User Email <span> <i class="fa fa-arrow-down-a-z"></i></span></td>
                                    <td>User Role</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allusers_list as $single_user) {
                                    $user_info = get_userdata($single_user->ID);  ?>
                                    <tr>
                                        <td><?php echo $user_info->ID; ?></td>
                                        <td><?php echo $user_info->user_login; ?></td>
                                        <td><?php echo $user_info->user_email; ?></td>
                                        <td><?php echo implode('',$user_info->roles); ?></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <?php //Pagination code
            $no_of_paginations = ceil($count / $per_page);
            if ($cur_page >= 7) {
                $start_loop = $cur_page - 3;
                if ($no_of_paginations > $cur_page + 3)
                    $end_loop = $cur_page + 3;
                else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                    $start_loop = $no_of_paginations - 6;
                    $end_loop = $no_of_paginations;
                } else {
                    $end_loop = $no_of_paginations;
                }
            } else {
                $start_loop = 1;
                if ($no_of_paginations > 7)
                    $end_loop = 7;
                else
                    $end_loop = $no_of_paginations;
            }

            if ($previous_btn && $cur_page > 1) {
                $pre = $cur_page - 1;
                $prebtn_status = 'enabled';
            } elseif ($previous_btn) {
                $prebtn_status = 'disabled';
            }

            if ($next_btn && $cur_page < $no_of_paginations) {
                $nex = $cur_page + 1;
                $nextbtn_status = 'enabled';
            } elseif ($next_btn) { 
                $nextbtn_status = 'disabled';
            }

            // Pagination Buttons  ?>
            <div class='codja-pagination'>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <li p='<?php echo $pre; ?>' class="page-item <?php echo $prebtn_status;?>">
                            <a class="page-link" href="javascript: void(0);">Previous</a>
                        </li>
                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) { 
                            if ($cur_page == $i) { 
                                $active = 'active';
                            } else {
                                $active = 'enabled';
                            }?>
                            <li p='<?php echo $i; ?>' class="page-item <?php echo $active; ?>">
                                <a class="page-link" href="javascript: void(0);"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <li p='<?php echo $nex; ?>' class="page-item <?php echo $nextbtn_status;?>">
                            <a class="page-link" href="javascript: void(0);">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php } else {
            echo '<p>Sorry, no records found.</p>';
        }
    }
    exit();
}
