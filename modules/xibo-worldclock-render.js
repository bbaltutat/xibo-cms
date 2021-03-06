/**
 * Copyright (C) 2020 Xibo Signage Ltd
 *
 * Xibo - Digital Signage - http://www.xibo.org.uk
 *
 * This file is part of Xibo.
 *
 * Xibo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Xibo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Xibo.  If not, see <http://www.gnu.org/licenses/>.
 */
jQuery.fn.extend({
    xiboWorldClockRender: function(options, body) {
        const worldClocks = options.worldClocks;
        const self = this;

        // Update clocks
        const updateClocks = function() {
            const timeNow = moment();

            for(let index = 0;index < worldClocks.length; index++) {
                // Get time according to timezone
                const t = timeNow.tz(worldClocks[index].clockTimezone);
                const $clockContainer = $(self).find('#clock' + index);

                $clockContainer.find('.year').html(t.year());
                $clockContainer.find('.month').html(t.month() + 1);
                $clockContainer.find('.week').html(t.week());
                $clockContainer.find('.day').html(t.date());
                $clockContainer.find('.hour').html(t.hours());
                $clockContainer.find('.minutes').html(t.minutes());
                $clockContainer.find('.seconds').html(t.seconds());

                $clockContainer.find('.momentClockTag').each(function() {
                    $(this).html(t.format($(this).attr("format")));
                });

                const secondAnalog = t.seconds() * 6;
                const minuteAnalog = t.minutes() * 6 + secondAnalog / 60;
                const hourAnalog = ((t.hours() % 12) / 12) * 360 + 90 + minuteAnalog / 12;

                $clockContainer.find('.analogue-clock-hour').css("transform", "rotate(" + hourAnalog + "deg)");
                $clockContainer.find('.analogue-clock-minute').css("transform", "rotate(" + minuteAnalog + "deg)");
                $clockContainer.find('.analogue-clock-second').css("transform", "rotate(" + secondAnalog + "deg)");
            }
        };

        // Default options
        var defaults = {
            "duration": "30",
            "previewWidth": 0,
            "previewHeight": 0,
            "scaleOverride": 0
        };

        options = $.extend({}, defaults, options);

        // Calculate the dimensions of each item based on the preview/original dimensions and col/row number
        var width = 0;
        var height = 0;

        if (options.previewWidth === 0 || options.previewHeight === 0) {
            width = options.widgetDesignWidth;
            height = options.widgetDesignHeight;
        } else {
            width = options.previewWidth;
            height = options.previewHeight;
        }

        if (options.scaleOverride !== 0) {
            width = width / options.scaleOverride;
            height = height / options.scaleOverride;
        }

        // Container dimensions
        const containerWidth = $(this).width();
        const containerHeight = $(this).height();

        // Element dimensions
        const elWidth = width;
        const elHeight = height;

        // Content dimensions and scale ( to create multiple elements based on the body scale fomr the xibo scaler )
        const contentWidth = (options.clockCols > 1) ? (width * options.clockCols) : width;
        const contentHeight = (options.clockRows > 1) ? (height * options.clockRows) : height;
        const contentScaleX = containerWidth / contentWidth;
        const contentScaleY = containerHeight / contentHeight;

        // For each matched element
        this.each(function() {
            $(this).find('#content').css('transform-origin', 'top left');
            $(this).find('#content').css('transform', 'scale(' + Math.min(contentScaleX, contentScaleY) + ')');
            $(this).find('#content').width(contentWidth);
            $(this).find('#content').height(contentHeight);

            for(let index = 0;index < worldClocks.length; index++) {
                // Append template to the preview
                let $newItem = $('<div>').attr('id', 'clock' + index).addClass('world-clock').append(body);

                // Add label or timezone name
                $newItem.find('.world-clock-label').html((worldClocks[index].clockLabel != '') ? worldClocks[index].clockLabel : worldClocks[index].clockTimezone);

                // Set dimensions
                $newItem.width(elWidth);
                $newItem.height(elHeight);
                $newItem.css('overflow', 'hidden');
                $newItem.css('float', 'left');
                
                // Check if clock has highlighted class
                if(worldClocks[index].clockHighlight == 'on') {
                    $newItem.addClass('highlighted');
                }

                // Check if the element is outside the drawing area ( cols * rows )
                if((index + 1) > (options.clockCols * options.clockRows)) {
                    $newItem.hide();
                }

                // Add content to the main container
                $(this).find('#content').append($newItem);
            }

            // Update clocks
            updateClocks(); // run function once at first to avoid delay

            // Update every second
            setInterval(updateClocks, 1000);
        });

        return $(this);
    }
});