{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Blade View Component --}}
<span class="xs-star-rating">
  @for($i=0;$i<$rating;$i++)
    <i class="fa fa-star active-star"></i>
  @endfor
  @for($i=0;$i<(5-$rating);$i++)
    <i class="fa fa-star"></i>
  @endfor
</span>
