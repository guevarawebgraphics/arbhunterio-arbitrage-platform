<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('pages')->delete();
        
        \DB::table('pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Home',
                'slug' => 'home',
                'content' => '<div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0">A better way to start sharing your contents online.</h2></div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                        <div class="col mb-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-file-earmark-text"></i></div>
                            <h2 class="h5">Dynamic Page Management</h2>
                            <p class="mb-0">Allows you to create, manage and customize a page for your desired contents with a help of a rich text editor.</p>
                        </div>
                        <div class="col mb-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-chat-left-text"></i></div>
                            <h2 class="h5">Default Features</h2>
                            <p class="mb-0">With default and highly customizable features such as blogs, pages, galleries, etc.</p>
                        </div>
                        <div class="col mb-5 mb-md-0 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-file-earmark-person"></i></div>
                            <h2 class="h5">Authentication with Custom Permissions</h2>
                            <p class="mb-0">2 Layer of security for your web application which consists of Authentication based login with Permissions and Roles.</p>
                        </div>
                        <div class="col h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                            <h2 class="h5">Cloud based / Lightweigth</h2>
                            <p class="mb-0">100% cloud-based which requires nothing but a computer and an internet connection.</p>
                        </div>
                    </div>
                </div>',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'About Us',
                'slug' => 'about-us',
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam quis dapibus dui, quis viverra est. Vestibulum ullamcorper odio sit amet accumsan consectetur. Cras fringilla vehicula ex non cursus. Nulla et enim ac elit efficitur congue. Mauris iaculis metus orci, at semper metus sagittis et. Quisque fringilla massa eu porttitor lacinia. Maecenas elementum arcu sit amet egestas vestibulum. Duis leo enim, facilisis posuere sapien sed, pellentesque luctus augue. Nulla molestie sit amet magna quis condimentum. Morbi scelerisque euismod nisl, at tincidunt arcu sagittis sit amet. Nulla convallis ultrices elit eu ornare. Duis convallis ex sit amet risus volutpat, at iaculis mi luctus. Suspendisse maximus, mi non feugiat ultricies, tellus est ultrices orci, a volutpat tortor ante a purus. Sed sollicitudin vulputate libero, lobortis suscipit augue luctus sit amet. Ut id ultricies enim, nec euismod dolor. Fusce nec accumsan lorem, quis feugiat leo.</p><p>Nunc eget sem finibus, pulvinar enim ut, hendrerit diam. In vitae sodales enim, vel auctor urna. Etiam commodo, ante pharetra varius euismod, odio orci faucibus dui, ac tempor lacus sem non odio. Vivamus consectetur eros nec leo laoreet, non varius enim vulputate. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut tellus dui, aliquet at semper eget, imperdiet a nisi. Mauris vel ex leo. Integer pharetra sollicitudin ipsum, id convallis ante euismod ut. In in eros eleifend, facilisis ante eu, porttitor odio. Sed lobortis velit eu orci viverra bibendum.</p><p>Duis pellentesque, dui sit amet tempor ultrices, erat mi cursus urna, sit amet dignissim tellus lorem at quam. Mauris scelerisque congue justo, non accumsan est consequat eu. Aenean vestibulum feugiat turpis quis dictum. Praesent mattis quam vel magna convallis lobortis. Sed commodo luctus erat, ultricies suscipit dui scelerisque vitae. Fusce consequat lectus sit amet arcu hendrerit rutrum. Aliquam in leo leo. Curabitur vel hendrerit odio. Nulla vel est eget sem mollis volutpat.</p>',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 2,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 3,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Blogs',
                'slug' => 'blogs',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 4,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Default',
                'slug' => 'default-page',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 5,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Privacy',
                'slug' => 'privacy',
                'content' => '<p>My CMS V2.1 Privacy Policy<br />
                This Privacy Policy was last modified on (02 Jul 2020)</p>
                &nbsp;
                
                <p>My CMS V2.1&nbsp;("us", "we", or "our") operates http://www.my-cms-ph.dev (the "Site"). This page informs you of our policies regarding the collection, use and disclosure of Personal Information we receive from users of the Site.</p>
                &nbsp;
                
                <p>We use your Personal Information only for providing and improving the Site. By using the Site, you agree to the collection and use of information in accordance with this policy.</p>
                &nbsp;
                
                <p><b>Information Collection and Use</b></p>
                
                <p>While using our Site, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information may include, but is not limited to your name ("Personal Information").</p>
                &nbsp;
                
                <p><b>Log Data</b></p>
                
                <p>Like many site operators, we collect information that your browser sends whenever you visit our Site ("Log Data"). This Log Data may include information such as your computer\'s Internet Protocol ("IP") address, browser type, browser version, the pages of our Site that you visit, the time and date of your visit, the time spent on those pages and other statistics.</p>
                &nbsp;
                
                <p><b>Cookies</b></p>
                
                <p>Cookies are files with small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer\'s hard drive.</p>
                &nbsp;
                
                <p>Like many sites, we use "cookies" to collect information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Site.</p>
                &nbsp;
                
                <p><b>Security</b></p>
                
                <p>The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage, is 100% secure. While we strive to use commercially acceptable means to protect your Personal Information, we cannot guarantee its absolute security.</p>
                
                <p><b>Changes to This Privacy Policy</b></p>
                
                <p>My CMS V2.1 may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on the Site. You are advised to review this Privacy Policy periodically for any changes.</p>
                
                <p><b>Contact Us</b></p>
                
                <p>If you have any questions about this Privacy Policy, please contact us.</p>',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 6,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Terms',
                'slug' => 'terms',
                'content' => '<p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern by My CMS V2.1 relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.</p>
                &nbsp;
                
                <p>The term ‘My CMS V2.1’ or ‘us’ or ‘we’ refers to the owner of the website. The term ‘you’ refers to the user or viewer of our website.</p>
                &nbsp;
                
                <p>The use of this website is subject to the following terms of use:</p>
                &nbsp;
                
                <p>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</p>
                &nbsp;
                
                <p>This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, the following personal information may be stored by us for use by third parties: IP and Cookies. Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</p>
                &nbsp;
                
                <p>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</p>
                &nbsp;
                
                <p>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</p>
                &nbsp;
                
                <p>All trademarks reproduced in this website, which are not the property of, or licensed to the operator, are acknowledged on the website.</p>
                &nbsp;
                
                <p>Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offence. From time to time, this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</p>
                &nbsp;
                
                <p>Your use of this website and any dispute arising out of such use of the website is subject to the laws Philippines.</p>',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 7,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Customer Login',
                'slug' => 'user/login',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 11,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Customer Register',
                'slug' => 'user/register',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 12,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Customer Forgot Password',
                'slug' => 'user/password/email',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 13,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Customer Dashboard',
                'slug' => 'dashboard',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 14,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Customer Orders',
                'slug' => 'orders',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 15,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Customer Address',
                'slug' => 'orders',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 16,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Customer Account Details',
                'slug' => 'account-details',
                'content' => '',
                'banner_image' => '',
                'banner_description' => '',
                'is_active' => 1,
                'seo_meta_id' => 16,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
        ));
    }
}
