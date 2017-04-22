<?php
/**
 * Created by PhpStorm.
 * User: Tharushi
 * Date: 4/19/2017
 * Time: 3:35 PM
 */

?>


<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>
    <ul class="nav menu">
        <li class="{{ Request::segment(1) === 'customer' ? 'active' : null }}"><a href="{{ url('customer') }}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Customer</a></li>
        <li class="{{ Request::segment(1) === 'contact' ? 'active' : null }}"><a href="{{ url('contact') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Contact</a></li>
        <li class="{{ Request::segment(1) === 'activity' ? 'active' : null }}"><a href="{{ url('activity') }}"><svg class="glyph stroked app-window"><use xlink:href="#stroked-app-window"></use></svg> Activity</a></li>
        <li role="presentation" class="divider"></li>
        <li><a href=""><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
    </ul>
    <div class="attribution"> 	&copy; 2017 </div>
</div><!--/.sidebar-->

