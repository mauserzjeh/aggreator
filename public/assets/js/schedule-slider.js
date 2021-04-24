$(() => {
    if ($('.schedule-slider-container')[0]) {
        $('.schedule-slider-container').each(function () {
            let slider = $(this).find('.range-slider');
            let sliderId = slider.attr('id');

            let minValue = slider.data('range-value-min');
            let maxValue = slider.data('range-value-max');

            let rangeLow = $(this).find('.range-slider-value-low');
            let rangeLowValue = rangeLow.data('range-value-low');
            let rangeLowInput = $(this).find('.input-range-slider-value-low');

            let rangeHigh = $(this).find('.range-slider-value-high');
            let rangeHighValue = rangeHigh.data('range-value-high');
            let rangeHighInput = $(this).find('.input-range-slider-value-high');

            let s = document.getElementById(sliderId);
            let t = [rangeLow, rangeHigh];
            let i = [rangeLowInput, rangeHighInput];

            noUiSlider.create(s, {
                start: [rangeLowValue, rangeHighValue],
                connect: !0,
                step: 5,
                range: {
                    min: parseInt(minValue),
                    max: parseInt(maxValue)
                },
                format: {
                    to: function (value) {
                        let to = moment().startOf('day').minutes(value).format('HH:mm')
                        return to;
                    },
                    from: function (value) {
                        return Number(value);
                    }
                }
            });

            s.noUiSlider.on('update', function (a, b) {
                t[b][0].textContent = a[b];
                let val = a[b].split(':');
                i[b].val(
                    parseInt(val[0]) * 60 + parseInt(val[1])
                );
            });
        });
    }
});

