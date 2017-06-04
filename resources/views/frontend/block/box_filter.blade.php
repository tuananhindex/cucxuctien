<div class="box categories" style="margin-top: -18px;">
  <ul>
  	<li class="filter-title"><span>Lọc theo giá</span></li>
    <li @if(isset($_GET['gia']) && $_GET['gia'] == 'asc') class="active" @endif><a title="Giá từ thấp đến cao" href="?gia=asc">Giá từ thấp đến cao</a></li>
    <li @if(isset($_GET['gia']) && $_GET['gia'] == 'desc') class="active" @endif><a title="Giá từ cao đến thấp" href="?gia=desc">Giá từ cao đến thấp</a></li>
    
  </ul>
</div>
