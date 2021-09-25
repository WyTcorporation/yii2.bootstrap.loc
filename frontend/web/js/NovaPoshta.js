var regionId = null,
    regionName = null,
    cityId = null,
    cityName = null;
function functionRegionId() {
    return regionId;
}
function functionRegionName() {
    return regionName;
}
function functionCityId() {
    return cityId;
}
function functionCityName() {
    return cityName;
}

function clearSelect2(one,two) {
    if (one) {
        $("#" + one + "").select2("val", " ", true);
    }
    if (two) {
        $("#"+two+"").select2("val", " ", true);
    }
}

$('#getRegions').on('select2:select', function (e) {
    regionId = e.params.data.id;
    regionName = e.params.data.text;
    //console.log(e.params.data);
});
$('#getCities').on('select2:select', function (e) {
    cityId = e.params.data.id;
    cityName = e.params.data.text;
    //console.log(e.params.data);
});
$('#getWarehouses').on('select2:select', function (e) {
    $('#order-address').val(e.params.data.text);
    //console.log(e.params.data);
});
