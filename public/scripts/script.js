// application prepared
var app = function () {

};

// Show more item on select business plan
app.prototype.sortByCategory = function (type) {
    if (type == 'business') {
        $('#by-business-plan').show();
    }
    else {
        $('#by-business-plan').hide();
    }
};
// add custom field to body
app.prototype.addCustomAdvertise = function (type) {
    $('#ad_type').val(type);
    $("#categoryByAdvertise").html(' ');
    $("#custom-fields").html(' ');
    if (type == 'business') {
        var option=`<option value="shoping">فروشگاهی</option>
            <option value="service">خدماتی</option>
            <option value="buy-center">مرکز خرید</option>`;
        $("#categoryByAdvertise").append(option);
        $("#ad_catergory").val('shoping');
        var html = `<div class="form-row">
                  <div class="col">
                        <label for = "website">سایت</label>
                        <input type = "text" id="website" name="website" class="form-control text-left">
                  </div>       
                    <div class="col">
                        <label for = "phone">همراه</label>
                        <input type = "text" id="phone" name="phone" class="form-control text-left">
                    </div>
                    <div class="col">
                        <label for = "home">تلفن</label>
                        <input type = "text" id="home" name="home" class="form-control text-left">
                    </div>
                    <div class="col">
                        <label for = "telegram">تلگرم</label>
                        <input type = "text" id="telegram" name="telegram" class="form-control text-left">
                    </div>
                  </div>
                    <div class="form-row">
                    <div class="col col-md-6">
                        <label for = "email">ایمیل</label>
                        <input type = "text" id="email" name="email" class="form-control text-left">
                    </div>
                    <div class="col col-md-3">
                        <label for = "video">ویدیو</label>
                        <input type = "file" id="video" name="video" class="form-control">
                    </div>
                    <div class="col col-md-3">
                        <label for = "pod">پادکست</label>
                        <input type = "file" id="pod" name="pod" class="form-control">
                    </div>
                    </div>`;


        $("#custom-fields").append(html)
    }
    else if (type == 'needed') {
        var option=`<option value="electronic">لوازم الکتریکی</option>
            <option value="landed">املاک</option>`;
        $("#categoryByAdvertise").append(option);
        $("#ad_catergory").val('eletronic');
        var html = `<div class="form-row">
                    <div class="col">
                        <label for = "price">قیمت</label>
                        <input type = "text" id="price" name="price" class="form-control">
                    </div>
                   <div class="col">
                        <label for = "phone">شماره تماس</label>
                        <input type = "text" id="phone" name="phone" class="form-control">
                    </div>
                    </div>`;
        $("#custom-fields").append(html)
    }
    else {
        console.log('another');
    }
};
app.prototype.categoryByAdvertise=function (type) {
    $("#ad_catergory").val(type);

    if(type=='service')
    {
        var ser =`<div class="form-group">
            <label for = "reserve">آدرس سیستم رزرو</label>
            <input type = "text" id="reserve" name="reserve" class="form-control">
        </div>`;
        $("#custom-fields").append(ser);
    }
    if(type=='landed')
    { var land =`<div class="form-group">
            <label for = "land">مساحت(متراژ)</label>
            <input type = "text" id="land" name="land" class="form-control">
        </div>`;
        $("#custom-fields").append(land);
    }
};
// application init object
var __app = new app();