@if (Session::has('success'))
<p style="width: 100%; color:#fff; background-color:green; text-align:center; font-size:20px; font-weight:600;  padding:5px;margin-bottom:5px; ">
 {{Session::get('success')}}
</p>

@endif