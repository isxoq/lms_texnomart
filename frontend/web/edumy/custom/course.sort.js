/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 27.05.2021, 16:41
 */

function updateViaAjax(url, scroll = true) {

    $('body').addClass('loading')

    if (scroll) {
        scrollToTop()
    }

    changeurl(url)
    $.ajax({
        'url': url,
        'success': function (result) {
            if (result.success) {
                $('#courses-list-container').html(result.content)
            }
        }
    }).done(function () {
        $('body').removeClass('loading')
    })
}

function changeurl(url) {
    window.history.pushState("data", "Title", url);
}

function scrollToTop() {
    $("html").animate({
        scrollTop: $("#courses-list-container").offset().top - 230
    }, 1000);
}

function updateURLParameter(param, paramVal) {
    let url = window.location.href
    let newAdditionalURL = "";
    let tempArray = url.split("?");
    let baseURL = tempArray[0];
    let additionalURL = tempArray[1];
    let temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (let i = 0; i < tempArray.length; i++) {
            if (tempArray[i].split('=')[0] != param) {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }

    let rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

$(function () {

    $(document).on('change', '.custom-sortable-selection', function (e) {
        let optionSelected = $("option:selected", this);
        let url = optionSelected.data('url');
        updateViaAjax(url)
    })

    $(document).on('click', '.pagination-links-container a', function (e) {
        e.preventDefault()
        let url = $(this).attr('href');
        updateViaAjax(url)
    })

    $(document).on('submit', '#course-search-form', function (e) {

        e.preventDefault()
        let title = $('#custom-search-input').val()
        let url = updateURLParameter('title', title)
        updateViaAjax(url)

    })


    $(document).on('submit', '#custom-course-filter-form', function (e) {

        e.preventDefault()
        let data = $(this).serialize()
        let baseUrl = $('#course-all-base-url').val()
        let url = baseUrl + '?' + data

        updateViaAjax(url)
    })


    $(document).on('change', '#custom-course-filter-form input[type=checkbox]', function (e) {

        let form = $('#custom-course-filter-form')
        e.preventDefault()
        let data = form.serialize()
        let baseUrl = $('#course-all-base-url').val()
        let url = baseUrl + '?' + data

        updateViaAjax(url, false)
    })

})


