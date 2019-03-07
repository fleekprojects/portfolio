function ch_category() {
    var dd_categories = '<option value="">Select Category</option>';
    var dd_industries = '<option value="">Select Industry</option>';
    var dd_tags = '';
    var cat_id = $('#p_cat option:selected').val();
    var ind_id = $('#p_ind option:selected').val();
    var cat_ext = [];
    var ind_ext = [];
    var tag_ext = [];
    if (cat_id != '') {
        $.each(cat_arr, function(key, cat) {
            if ($.inArray(cat.cat_id, cat_ext) == -1) {
                dd_categories += '<option value="' + cat.cat_id + '" ' + (cat_id == cat.cat_id ? "selected" : "") + '>' + cat.cat_title + '</option>';
                cat_ext.push(cat.cat_id);
            }
        });
        $.each(ind_arr, function(key, ind) {
            if (ind.cat_id == cat_id && $.inArray(ind.ind_id, ind_ext) == -1) {
                dd_industries += '<option value="' + ind.ind_id + '" ' + (ind_id == ind.ind_id ? "selected" : "") + '>' + ind.ind_title + '</option>';
                ind_ext.push(ind.ind_id);
            }
        });
        $.each(tags_arr, function(key, tag) {
            if (tag.cat_id == cat_id && $.inArray(tag.tag_id, tag_ext) == -1) {
                dd_tags += '<li><label><input type="checkbox" name="tags_list[]" id="tagids' + tag.tag_id + '" value="' + tag.tag_id + '"><span> </span><p>' + tag.tag_title + '</p></label></li>';
                tag_ext.push(tag.tag_id);
            }
        });
        $("#p_cat").html(dd_categories);
        $("#p_ind").html(dd_industries);
        $("#p_tag").html(dd_tags);
        $("#AdvTags").slideDown();

    } else {
        $("#p_tag").html(dd_tags);
        $("#AdvTags").slideUp();
    }
}

function ch_industry() {
    var dd_categories = '<option value="">Select Category</option>';
    var dd_industries = '<option value="">Select Industry</option>';
    var dd_tags = '';
    var cat_id = $('#p_cat option:selected').val();
    var ind_id = $('#p_ind option:selected').val();
    var cat_ext = [];
    var ind_ext = [];
    var tag_ext = [];
    if (ind_id != '') {
        $.each(cat_arr, function(key, cat) {
            if (cat.ind_id == ind_id && $.inArray(cat.cat_id, cat_ext) == -1) {
                dd_categories += '<option value="' + cat.cat_id + '" ' + (cat_id == cat.cat_id ? "selected" : "") + '>' + cat.cat_title + '</option>';
                cat_ext.push(cat.cat_id);
            }
        });
        $.each(ind_arr, function(key, ind) {
            if ($.inArray(ind.ind_id, ind_ext) == -1) {
                dd_industries += '<option value="' + ind.ind_id + '" ' + (ind_id == ind.ind_id ? "selected" : "") + '>' + ind.ind_title + '</option>';
                ind_ext.push(ind.ind_id);
            }
        });
        $("#p_cat").html(dd_categories);
        $("#p_ind").html(dd_industries);
    }
    if ($('#p_cat option:selected').val() == "") {
        $("#p_tag").html(dd_tags);
        $("#AdvTags").slideUp();
    }
}
function resetfilter(){
    var dd_categories = '<option value="">Select Category</option>';
    var dd_industries = '<option value="">Select Industry</option>';
    var dd_tags = '';
    var cat_ext = [];
    var ind_ext = [];
    var tag_ext = [];
    $.each(cat_arr, function(key, cat) {
        if ($.inArray(cat.cat_id, cat_ext) == -1) {
            dd_categories += '<option value="' + cat.cat_id + '" ' + (cat.cat_id == "" ? "selected" : "") + '>' + cat.cat_title + '</option>';
            cat_ext.push(cat.cat_id);
        }
    });
    $.each(ind_arr, function(key, ind) {
        if ($.inArray(ind.ind_id, ind_ext) == -1) {
            dd_industries += '<option value="' + ind.ind_id + '" ' + (ind.ind_id == "" ? "selected" : "") + '>' + ind.ind_title + '</option>';
            ind_ext.push(ind.ind_id);
        }
    });
    $("#p_tag").html(dd_tags);
    $("#AdvTags").slideUp();
    $("#p_cat").html(dd_categories);
    $("#p_ind").html(dd_industries);
}