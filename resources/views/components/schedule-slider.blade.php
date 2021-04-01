 <!-- Range slider container -->
 <div class="schedule-slider-container">
     <!-- Range slider -->
     <div id="{{ $slider_id }}" class="range-slider" data-range-value-min="0" data-range-value-max="1439"></div>
     <!-- Range slider values -->
     <div class="row">
         <div class="col-6">
             <input type="hidden" value="{{ $value_low ?? 360 }}" class="input-range-slider-value-low" name="{{ $name_low }}">
             <span class="range-slider-value value-low range-slider-value-low" data-range-value-low="{{ $value_low ?? 360 }}"></span>
         </div>
         <div class="col-6 text-right">
             <input type="hidden" value="{{ $value_high ?? 1080 }}" class="input-range-slider-value-high" name="{{ $name_high }}">
             <span class="range-slider-value value-high range-slider-value-high" data-range-value-high="{{ $value_high ?? 1080}}"></span>
         </div>
     </div>
 </div>