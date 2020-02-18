<?php
/**
 * Created by PhpStorm.
 * User: pavel_duman
 * Date: 2/18/20
 * Time: 2:43 PM
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// Start Class
if ( ! class_exists( 'WPEX_Theme_Options' ) ) {
    
    class WPEX_Theme_Options {
        
        /**
         * Start things up
         *
         * @since 1.0.0
         */
        public function __construct() {
            
            // We only need to register the admin panel on the back-end
            if ( is_admin() ) {
                add_action( 'admin_menu', array( 'WPEX_Theme_Options', 'add_admin_menu' ) );
                add_action( 'admin_init', array( 'WPEX_Theme_Options', 'register_settings' ) );
            }
            
        }
       
        /**
         * Returns all theme options
         *
         * @since 1.0.0
         */
        public static function get_theme_options() {
            return get_option( 'theme_options' );
        }
        
        /**
         * Returns single theme option
         *
         * @since 1.0.0
         */
        public static function get_theme_option( $id ) {
            $options = self::get_theme_options();
            if ( isset( $options[$id] ) ) {
                return $options[$id];
            }
        }
        
        /**
         * Add sub menu page
         *
         * @since 1.0.0
         */
        public static function add_admin_menu() {
            add_menu_page(
                esc_html__( 'Theme Settings', 'text-domain' ),
                esc_html__( 'Theme Settings', 'text-domain' ),
                'manage_options',
                'theme-settings',
                array( 'WPEX_Theme_Options', 'create_admin_page' )
            );
        }
        
        /**
         * Register a setting and its sanitization callback.
         *
         * We are only registering 1 setting so we can store all options in a single option as
         * an array. You could, however, register a new setting for each option
         *
         * @since 1.0.0
         */
        public static function register_settings() {
            register_setting( 'theme_options', 'theme_options', array( 'WPEX_Theme_Options', 'sanitize' ) );
        }
        
        /**
         * Sanitization callback
         *
         * @since 1.0.0
         */
        public static function sanitize( $options ) {
            
            // If we have options lets sanitize them
            if ( $options ) {
                
                // Checkbox
                if ( ! empty( $options['checkbox_example'] ) ) {
                    $options['checkbox_example'] = 'on';
                } else {
                    unset( $options['checkbox_example'] ); // Remove from options if not checked
                }
                
                // Input
                if ( ! empty( $options['input_example'] ) ) {
                    $options['input_example'] = sanitize_text_field( $options['input_example'] );
                } else {
                    unset( $options['input_example'] ); // Remove from options if empty
                }
                
                // Select
                if ( ! empty( $options['select_example'] ) ) {
                    $options['select_example'] = sanitize_text_field( $options['select_example'] );
                }
                
            }
            
            // Return sanitized options
            return $options;
            
        }
        
        /**
         * Settings page output
         *
         * @since 1.0.0
         */
        public static function create_admin_page() { ?>
            
            <div class="wrap">
                
                <h1><?php esc_html_e( 'Theme Options', 'text-domain' ); ?></h1>
                
                <form method="post" action="options.php">
                    
                    <?php settings_fields( 'theme_options' ); ?>
                    <h2>Blog page settings</h2>
                    <table class="form-table wpex-custom-admin-login-table">
                        
                        <?php // Checkbox example ?>
<!--                        <tr valign="top">
                            <th scope="row"><?php /*esc_html_e( 'Checkbox Example', 'text-domain' ); */?></th>
                            <td>
                                <?php /*$value = self::get_theme_option( 'checkbox_example' ); */?>
                                <input type="checkbox" name="theme_options[checkbox_example]" <?php /*checked( $value, 'on' ); */?>> <?php /*esc_html_e( 'Checkbox example description.', 'text-domain' ); */?>
                            </td>
                        </tr>-->
                        
                        <?php // Text input example ?>
                        
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e( 'Title', 'text-domain' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'blog_title' ); ?>
                                <input type="text" name="theme_options[blog_title]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        
                        <?php // Select example ?>
                        <tr valign="top" class="wpex-custom-admin-screen-background-section">
                            <th scope="row"><?php esc_html_e( 'Show sitebar', 'text-domain' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'blog_sidebar' ); ?>
                                <select name="theme_options[blog_sidebar]">
                                    <?php
                                    $options = array(
                                        'none' => esc_html__( 'Not show', 'text-domain' ),
                                        'right' => esc_html__( 'Show right', 'text-domain' ),
                                        'left' => esc_html__( 'Show left', 'text-domain' ),
                                    );
                                    foreach ( $options as $id => $label ) { ?>
                                        <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
                                            <?php echo strip_tags( $label ); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    
                    </table>
                  <h2>Archive page settings</h2>
                  <table class="form-table wpex-custom-admin-login-table">
      
                      <?php // Checkbox example ?>
                    <!--                        <tr valign="top">
                            <th scope="row"><?php /*esc_html_e( 'Checkbox Example', 'text-domain' ); */?></th>
                            <td>
                                <?php /*$value = self::get_theme_option( 'checkbox_example' ); */?>
                                <input type="checkbox" name="theme_options[checkbox_example]" <?php /*checked( $value, 'on' ); */?>> <?php /*esc_html_e( 'Checkbox example description.', 'text-domain' ); */?>
                            </td>
                        </tr>-->
      
                      <?php // Text input example ?>

                    <tr valign="top">
                      <th scope="row"><?php esc_html_e( 'Title', 'text-domain' ); ?></th>
                      <td>
                          <?php $value = self::get_theme_option( 'archive_title' ); ?>
                        <input type="text" name="theme_options[archive_title]" value="<?php echo esc_attr( $value ); ?>">
                      </td>
                    </tr>
      
                      <?php // Select example ?>
                    <tr valign="top" class="wpex-custom-admin-screen-background-section">
                      <th scope="row"><?php esc_html_e( 'Show sitebar', 'text-domain' ); ?></th>
                      <td>
                          <?php $value = self::get_theme_option( 'archive_sidebar' ); ?>
                        <select name="theme_options[archive_sidebar]">
                            <?php
                            $options = array(
                                'none' => esc_html__( 'Not show', 'text-domain' ),
                                'right' => esc_html__( 'Show right', 'text-domain' ),
                                'left' => esc_html__( 'Show left', 'text-domain' ),
                            );
                            foreach ( $options as $id => $label ) { ?>
                              <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
                                  <?php echo strip_tags( $label ); ?>
                              </option>
                            <?php } ?>
                        </select>
                      </td>
                    </tr>

                  </table>
                    <?php submit_button(); ?>
                
                </form>
            
            </div><!-- .wrap -->
        <?php }
        
    }
}
new WPEX_Theme_Options();

// Helper function to use in your theme to return a theme option value
function myprefix_get_theme_option( $id = '' ) {
    return WPEX_Theme_Options::get_theme_option( $id );
}