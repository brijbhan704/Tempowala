<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <ul class="nav side-menu">
      <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
      <!-- <li><a><i class="fa fa-product-hunt" aria-hidden="true"></i> Manage Product <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/products">Product List</a></li>
            <li><a href="{{ url('/') }}/products/uploadcsv">Import CSV</a></li>
        </ul>
      </li> -->

      <li><a><i class="fa fa-truck" aria-hidden="true"></i> Vehicle list<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/vehicles">Vehicle List</a></li>
        </ul>
      </li>      
      <li><a><i class="fa fa-truck" aria-hidden="true"></i> Vehicle Type<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/vehicletypes">Vehicle Type List</a></li>
        </ul>
      </li> 
      <li><a><i class="fa fa-book" aria-hidden="true"></i> Booking list<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="{{ url('/') }}/bookings">Booking List</a></li>
        </ul>
      </li> 
      <li><a><i class="fa fa-users"></i> Customers<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/users">Customers List</a></li>
        </ul>
      </li> 
      
      <li><a><i class="fa fa-sticky-note"></i> Message <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/messages">Message List</a></li>
          <li><a href="{{ url('/') }}/send_message">Send Message</a></li>
        </ul>
      </li> 
        <li><a><i class="fa fa-tags"></i> Coupon <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ url('/') }}/coupons">Coupon List</a></li>
        </ul>
      </li> 
      <li><a href="{{ url('/') }}/users/settings/1"><i class="fa fa-cog fa-spin fa-3x fa-fw" aria-hidden="true"></i> Common Settings<span class="fa fa-chevron-down"></span></a>
        
      </li>  
    </ul>
  </div>

</div>
