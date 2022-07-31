$(function () {
  'use strict';

  // $.fn.DataTable.ext.errMode = function (settings, tn, msg) {
  //   if (settings && settings.jqXHR && settings.jqXHR.status == 405) {
  //     run_waitMe('.wait-containter', true);
  //     Swal.fire({
  //       text: "ログインセッションが切れました",
  //       showCancelButton: false,
  //       allowOutsideClick: false,
  //       confirmButtonText: '再ログイン'
  //     }).then(function (result) {
  //       window.location = (window.location.origin + '/logout');
  //     })

  //     return
  //   }
  // };

  // $.ajaxSetup({
  //   headers: {
  //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
  //     'Authorization': $('meta[name="csrf-token-api"]').attr('content')
  //   },
  //   complete: function (xhr, stat) {
  //     if (typeof xhr.responseJSON !== "undefined") {
  //       if (xhr.responseJSON.code === 422) {
  //         run_waitMe('.wait-containter', true);
  //         Swal.fire({
  //           text: "ログインセッションが切れました",
  //           showCancelButton: false,
  //           allowOutsideClick: false,
  //           confirmButtonText: '再ログイン'
  //         }).then(function (result) {
  //           window.location = (window.location.origin + '/logout');
  //         })
  //       }

  //       if (xhr.responseJSON.code === 405) {
  //         run_waitMe('.wait-containter', true);
  //         Swal.fire({
  //           text: "ログインセッションが切れました",
  //           showCancelButton: false,
  //           allowOutsideClick: false,
  //           confirmButtonText: '再ログイン'
  //         }).then(function (result) {
  //           window.location = (window.location.origin + '/logout');
  //         })
  //       }

  //     }

  //     if (xhr.status == 405) {
  //       run_waitMe('.wait-containter', true);
  //       Swal.fire({
  //         text: "ログインセッションが切れました",
  //         showCancelButton: false,
  //         allowOutsideClick: false,
  //         confirmButtonText: '再ログイン'
  //       }).then(function (result) {
  //         window.location = (window.location.origin + '/logout');
  //       })
  //     }

  //   }
  // });

  if (($.trim($('.slim-navbar .container .nav').text())).length == 0) {
    $('.slim-navbar').remove();
  }

  $('input[type="text"]').on('keyup', function (e) {
    var value = $(this).val();
    var string = value.replace(/  +/g, ' ');
    $(this).val(string);
  });

  $('input[type="text"]').on('focusout', function (e) {
    var value = $(this).val();
    var string = value.trim();
    $(this).val(string);
  });

  // showing 2nd level sub menu while hiding others
  $('.sidebar-nav-link').on('click', function (e) {
    run_waitMe('.wait-containter');
    var subMenu = $(this).next();

    $(this).parent().siblings().find('.sidebar-nav-sub').slideUp();
    $('.sub-with-sub ul').slideUp();

    if (subMenu.length) {
      e.preventDefault();
      subMenu.slideToggle();
    }
  });

  $('.nav-link, .nav-sub-link').on('click', function (e) {
    run_waitMe('.wait-containter');
  });

  // showing 3rd level sub menu while hiding others
  $('.sub-with-sub .nav-sub-link').on('click', function (e) {
    e.preventDefault();
    $(this).parent().siblings().find('ul').slideUp();
    $(this).next().slideDown();
  });

  $('#slimSidebarMenu').on('click', function (e) {
    e.preventDefault();
    if (window.matchMedia('(min-width: 1200px)').matches) {
      $('body').toggleClass('hide-sidebar');
    } else {
      $('body').toggleClass('show-sidebar');
    }
  });

  if ($.fn.perfectScrollbar) {
    $('.slim-sidebar').perfectScrollbar({
      suppressScrollX: true
    });
  }

  $('[data-toggle="tooltip"]').tooltip({ trigger: 'hover' });

  $(window).resize(function () {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  });

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  });

  /////////////////// START: TEMPLATE SETTINGS /////////////////////
  var loc = window.location.pathname;
  var path = loc.split('/');
  var isRtl = false;   // path[2] for production
  var isSidebar = false; // path[2] for production
  var newloc = '';

  // inject additional link tag for header skin
  $('head').append('<link id="headerSkin" rel="stylesheet" href="">');

  // show/hide template options panel
  $('body').on('click', '.template-options-btn', function (e) {
    e.preventDefault();
    $('.template-options-wrapper').toggleClass('show');
  });

  // set current page to light mode
  $('body').on('click', '.skin-light-mode', function (e) {
    e.preventDefault();
    newloc = loc.replace('template-dark', 'template');
    if (isSidebar) {
      newloc = loc.replace('sidebar-dark', 'sidebar');
    }
    $(location).attr('href', newloc);
  });

  // set current page to dark mode
  $('body').on('click', '.skin-dark-mode', function (e) {
    e.preventDefault();
    if (loc.indexOf('template-dark') >= 0) {
      newloc = loc;
    } else {
      newloc = loc.replace('template', 'template-dark');
      if (isSidebar) {
        newloc = loc.replace('sidebar', 'sidebar-dark');
      }
    }
    $(location).attr('href', newloc);
  });

  // set current page to rtl/ltr direction
  $('body').on('click', '.slim-direction', function () {
    var val = $(this).val();

    if (val === 'rtl') {
      if (!isRtl) {
        if (path[3]) {
          newloc = '/' + path[1] + '/' + path[2] + '-rtl/' + path[3];
        } else {
          newloc = '/' + path[1] + '/' + path[2] + '-rtl/';
        }
        $(location).attr('href', newloc);
      }
    } else {
      if (isRtl) {
        if (path[3]) {
          newloc = '/' + path[1] + '/' + path[2].replace('-rtl', '') + '/' + path[3];
        } else {
          newloc = '/' + path[1] + '/' + path[2].replace('-rtl', '') + '/';
        }
        $(location).attr('href', newloc);
      }
    }
  });

  // set current page to sidebar/navbar
  $('body').on('click', '.nav-layout', function () {
    var val = $(this).val();

    if (val === 'vertical') {
      if (!isSidebar) {
        if (loc.indexOf('-dark') >= 0) {
          if (path[3]) {
            newloc = '/' + path[1] + '/sidebar-dark/' + path[3];
          } else {
            newloc = '/' + path[1] + '/sidebar-dark/';
          }
        } else {
          if (path[3]) {
            newloc = '/' + path[1] + '/sidebar/' + path[3];
          } else {
            newloc = '/' + path[1] + '/sidebar/';
          }
        }
        $(location).attr('href', newloc);
      }
    } else {
      if (isSidebar) {
        if (path[3]) {
          newloc = '/' + path[1] + '/' + path[2].replace('sidebar', 'template') + '/' + path[3];
        } else {
          newloc = '/' + path[1] + '/' + path[2].replace('sidebar', 'template') + '/';
        }
        $(location).attr('href', newloc);
      }
    }
  });

  // toggles header to sticky
  $('body').on('click', '.sticky-header', function () {
    var val = $(this).val();
    if (val === 'yes') {
      $.cookie('sticky-header', 'true');
      $('body').addClass('slim-sticky-header');
    } else {
      $.removeCookie('sticky-header');
      $('body').removeClass('slim-sticky-header');
    }
  });

  // toggles sidebar to sticky
  $('body').on('click', '.sticky-sidebar', function () {
    if ($('.slim-sidebar').length) {
      var val = $(this).val();
      if (val === 'yes') {
        $.cookie('sticky-sidebar', 'true');
        $('body').addClass('slim-sticky-sidebar');
      } else {
        $.removeCookie('sticky-sidebar');
        $('body').removeClass('slim-sticky-sidebar');
      }
    } else {
      alert('Can only be used when navigation is set to vertical');
      $('.sticky-sidebar[value="no"]').prop('checked', true);
    }
  });

  // set skin to header
  $('body').on('click', '.header-skin', function () {
    var val = $(this).val();
    if (val !== 'default') {
      $.cookie('header-skin', val);
      $('#headerSkin').attr('href', '../css/slim.' + val + '.css');
    } else {
      $.removeCookie('header-skin');
      $('#headerSkin').attr('href', '');
    }
  });

  // set page to wide
  $('body').on('click', '.full-width', function () {
    var val = $(this).val();
    if (val === 'yes') {
      $.cookie('full-width', 'true');
      $('body').addClass('slim-full-width');
    } else {
      $.removeCookie('full-width');
      $('body').removeClass('slim-full-width');
    }
  });


  $.fn.button = function (action) {
    if (action === 'loading' && this.data('loading-text')) {
      this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
    }
    if (action === 'reset' && this.data('original-text')) {
      this.html(this.data('original-text')).prop('disabled', false);
    }
  };

  if ($('.select2').length > 0) {
    $('.select2').select2({
      minimumResultsForSearch: ''
    });
  }


  if ($('.lazy').length > 0) {
    $('.lazy').lazy({
      effect: "fadeIn",
      effectTime: 2000,
      threshold: 0
    });
  }

  if ($('.perfectScrollbar').length > 0) {
    $('.perfectScrollbar').perfectScrollbar();
  }

  if ($('.summernote').length > 0) {
    $('.summernote').summernote({
      dialogsInBody: true,
      height: 300,                 // set editor height
      minHeight: 300,             // set minimum height of editor
      maxHeight: 500,             // set maximum height of editor
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        //  ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['picture']],
        //  ['insert', ['link', 'picture', 'video']],
        //  ['view', ['fullscreen', 'codeview']]
      ],
      // maxTextLength: 2001,
      callbacks: {
        onImageUpload: function (image) {
          var editor = $(this);
          uploadImageContent(image, editor);
        }
      }
    });
    // $('div.note-group-select-from-files').remove();
    // $('.note-btn').attr('title', '');
    if ($('.summernote').next('.note-editor').length !== 0) {
      $('.modal[aria-label="Insert Image"] input[name=files]').prop("multiple", false);
      $('.modal[aria-label="Insert Image"] input[name=files]').attr('accept', '.png, .jpg, .jpeg')
    }
  }

  window.Parsley.addValidator("minimumage", {
    validateString: function (value, requirements) {
      // get validation requirments
      var reqs = value.split("/"),
        day = reqs[0],
        month = reqs[1],
        year = reqs[2];

      // check if date is a valid
      var birthday = new Date(year + "-" + month + "-" + day);

      // Calculate birtday and check if age is greater than 18
      var today = new Date();

      var age = today.getFullYear() - birthday.getFullYear();
      var m = today.getMonth() - birthday.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) {
        age--;
      }

      return age >= requirements;
    }
  });

  $("input[type='number']").keypress(function (e) {
    var maxlengthNumber = parseInt($(this).attr('maxlength'));
    var inputValueLength = $(this).val().length + 1;
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
    if (maxlengthNumber < inputValueLength) {
      return false;
    }
  });

  $(document).on('hidden.bs.modal', function (event) {
    if ($('.modal:visible').length) {
      $('body').addClass('modal-open');
    }
  });

  $(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function () {
      $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
  });

  $('body').tooltip({ selector: '[data-toggle="tooltip"]' });

  $.fn.extend({
    treed: function (o) {

      var openedClass = 'fa-chevron-down';
      var closedClass = 'fa-chevron-right';

      if (typeof o != 'undefined') {
        if (typeof o.openedClass != 'undefined') {
          openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined') {
          closedClass = o.closedClass;
        }
      };

      //initialize each of the top levels
      var tree = $(this);
      tree.addClass("tree");
      tree.find('li').has("ul").each(function () {
        var branch = $(this); //li with children ul
        branch.prepend("<i class='indicator fa " + closedClass + "'></i>");
        branch.addClass('branch');
        branch.on('click', function (e) {
          if (this == e.target) {
            var icon = $(this).children('i:first');
            icon.toggleClass(openedClass + " " + closedClass);
            $(this).children().children().toggle();
          }
        })
        branch.children().children().toggle();
      });
      //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function () {
        $(this).on('click', function () {
          $(this).closest('li').click();
        });
      });
      //fire event to open branch if the li contains an anchor instead of text
      tree.find('.branch>a').each(function () {
        $(this).on('click', function (e) {
          $(this).closest('li').click();
          e.preventDefault();
        });
      });
      //fire event to open branch if the li contains a button instead of text
      tree.find('.branch>button').each(function () {
        $(this).on('click', function (e) {
          $(this).closest('li').click();
          e.preventDefault();
        });
      });
    }
  });

  window.Parsley.on('field:error', function () {
    this.$element.closest('.tab-pane').addClass('validation_error');
    $('.tab-content .tab-pane.validation_error:eq(0)').addClass('first_tab_with_errors');
    var current_tab_id = $('.tab-content .tab-pane.validation_error.first_tab_with_errors').attr('id');
    $('.nav-tabs a[href="' + '#' + current_tab_id + '"]').tab('show');
    $('.nav-tabs a[href="' + '#' + (this.$element.closest('.tab-pane').attr('id')) + '"]').addClass('validation_errors');

    this.$element.parent().parent().parent().parent().parent().find('label.form-control-label:not(.label-no-margin)').addClass('margin-top-center');
    this.$element.parent().parent().parent().find('label.form-control-label:not(.label-no-margin)').addClass('margin-top-center');
    this.$element.parent().parent().find('label.form-control-label:not(.label-no-margin)').addClass('margin-top-center');

    this.$element.parent().parent().parent().find('.div-btn-del').addClass('margin-top-center');
    this.$element.parent().parent().parent().find('.div-checkbox').addClass('margin-top-center');
  });

  $('.parsley-select > select').on("select2:select", function(e) {
    $(this).parsley().validate();
  });

});

var xhrListLocation;
var uploadImageContent = function (files, editor) {
  var formData = new FormData();
  formData.append("file", files[0]);
  $.ajax({
    url: base_admin + "/ajax_upload",
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
    type: "post",
    success: function (response) {
      if (response.code == '200') {
        if ($('#btnNews').length > 0) {
          $('#btnNews').attr('disabled', false);
        }
        var image = $('<img>').attr('src', response.data);
        $(editor).summernote("insertNode", image[0]);
      } else {
        return;
      }
    },
    error: function (data) {
    }
  });
}

var goBack = function () {
  window.history.back();
}

var CalDistance = function (lat1, lon1, lat2, lon2, unit) {
  if ((lat1 == lat2) && (lon1 == lon2)) {
    return 0;
  }
  else {
    var radlat1 = Math.PI * lat1 / 180;
    var radlat2 = Math.PI * lat2 / 180;
    var theta = lon1 - lon2;
    var radtheta = Math.PI * theta / 180;
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    if (dist > 1) {
      dist = 1;
    }
    dist = Math.acos(dist);
    dist = dist * 180 / Math.PI;
    dist = dist * 60 * 1.1515;
    if (unit == "K") {
      dist = dist * 1.609344;
      if (dist.toFixed(2) > distance_check) {
        return "<span class='text-danger'>" + dist.toFixed(2) + " km </span> (" + (distance_check - dist).toFixed(2) + " km)";
      } else {
        return "<span class='text-success'>" + dist.toFixed(2) + " km </span> (" + (distance_check - dist).toFixed(2) + " km)";
      }

    }
    else if (unit == "N") {
      dist = dist * 0.8684;
      return dist.toFixed(2) + ' miles';
    } else {
      var newDistance = distance_check * 1000;
      if (dist.toFixed(2) > newDistance) {
        return "<span class='text-danger'>" + dist.toFixed(2) + " m </span> (" + (newDistance - dist).toFixed(2) + " m)";
      } else {
        return "<span class='text-success'>" + dist.toFixed(2) + " m </span> (" + (newDistance - dist).toFixed(2) + " m)";
      }
      return dist.toFixed(2) + ' m';
    }

  }
}

var CalTime = function (time1, time2) {
  var duration = moment.duration(time2.diff(time1));
  var minutes = duration.asMinutes();
  return minutes.toFixed(0);
}

var makeId = function (length) {
  var result = '';
  var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

var getUrlVars = function (params) {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
    vars[key] = value;
  });
  if (Object.keys(vars).length == 0) {
    return '';
  }
  return vars[params];
}

var run_waitMe = function (el, stop) {
  if (stop) {
    $(el).waitMe('hide');
  } else {
    $(el).waitMe({
      effect: 'timer',
      text: 'お待ちください',
      bg: 'rgb(255 255 255 / 49%)',
      color: '#000',
      maxSize: '',
      waitTime: -1,
      textPos: 'vertical',
      fontSize: '',
      onClose: function (el) { }
    });
  }
};

var fetchSingleLocation = function (parent, el, type, value, selected) {
  resetSelectLocation(parent, type);
  var url_query = base_ajax + "/setting/location/fetch?type=" + type;
  if (typeof value !== 'undefined') {
    url_query += '&filter[get_parent]=' + value;
  }
  $.ajax({
    url: url_query,
    type: "get",
    beforeSend: function (jqXHR) {
      $.each(xhrListLocation, function (idx, xhr) {
        xhr.abort();
      });
      xhrListLocation = [];
      xhrListLocation.push(jqXHR);
    },
    success: function (response) {
      if (response.code == '200') {
        var result = response.data;
        if (result.length > 0) {
          $(el).html('').select2({
            data: {
              id: null,
              text: null
            }
          });
          $.each(result, function (k, v) {
            var option = new Option(v.name, v.id, false, false);
            $(el).append(option).trigger('change.select2');
          });
          $(el).val(null).trigger('change.select2');
        }
      } else {
        $(el).prop('disabled', true);
        Swal.fire({
          type: 'warning',
          title: 'Oops...',
          text: response.msg
        });
      }
      if (type === 'region') {
        initLocation = true;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $(el).prop('disabled', true);
      Swal.fire({
        type: 'warning',
        title: 'Oops...',
        text: Lang.get('main.modal.error_process')
      });
    }
  });
};

var LoadSingleLocation = function (parent, el, type, region, area, province, district, ward) {
  resetSelectLocation(parent, type);
  var url_query = base_ajax + "/setting/location/linked?parent=" + parent;
  if (region != null) {
    url_query += '&region=' + region;
  }
  if (area != null) {
    url_query += '&area=' + area;
  }
  if (province != null) {
    url_query += '&province=' + province;
  }
  if (district != null) {
    url_query += '&district=' + district;
  }
  if (ward != null) {
    url_query += '&ward=' + ward;
  }
  $.ajax({
    url: url_query,
    type: "get",
    success: function (response) {
      if (response.code == '200') {
        var result = response.data;
        if (Object.keys(result).length > 0) {
          if (region != null) {
            initSelectedLocation(el, 'region', result, region);
          }
          if (area != null) {
            initSelectedLocation(el, 'area', result, area);
          }
          if (province != null) {
            initSelectedLocation(el, 'province', result, province);
          }
          if (district != null) {
            initSelectedLocation(el, 'district', result, district);
          }
          if (ward != null) {
            initSelectedLocation(el, 'ward', result, ward);
          }
        }
      } else {
        $(el).prop('disabled', true);
        Swal.fire({
          type: 'warning',
          title: 'Oops...',
          text: response.msg
        });
      }
      if (type === 'region') {
        initLocation = true;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $(el).prop('disabled', true);
      Swal.fire({
        type: 'warning',
        title: 'Oops...',
        text: Lang.get('main.modal.error_process')
      });
    }
  });
};

var initSelectedLocation = function (el, type, data, value) {
  if (type == 'region') {
    var id = el + ' #region_id';
    var result = data.region;
  } else if (type == 'area') {
    var id = el + ' #area_id';
    var result = data.area;
  } else if (type == 'province') {
    var id = el + ' #province_id';
    var result = data.province;
  } else if (type == 'district') {
    var id = el + ' #district_id';
    var result = data.district;
  } else {
    var id = el + ' #ward_id';
    var result = data.ward;
  }

  $(id).html('').select2({
    data: {
      id: null,
      text: null
    }
  });
  $.each(result, function (k, v) {
    var option = new Option(v.name, v.id, false, false);
    $(id).append(option).trigger('change.select2');
  });
  $(id).val([value]).trigger('change.select2');
  $(id).prop('disabled', false);
}

var resetSelectLocation = function (el, type) {
  if (type == 'area') {
    $(el + ' #area_id, ' + el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').html('').select2({ data: { id: null, text: null } });
    $(el + ' #area_id, ' + el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').append(new Option(null, '', false, false)).trigger('change.select2');
    $(el + ' #area_id, ' + el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').prop('disabled', true);
  } else if (type == 'province') {
    $(el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').html('').select2({ data: { id: null, text: null } });
    $(el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').append(new Option(null, '', false, false)).trigger('change.select2');
    $(el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').prop('disabled', true);
  } else if (type == 'district') {
    $(el + ' #district_id, ' + el + ' #ward_id').html('').select2({ data: { id: null, text: null } });
    $(el + ' #district_id, ' + el + ' #ward_id').append(new Option(null, '', false, false)).trigger('change.select2');
    $(el + ' #district_id, ' + el + ' #ward_id').prop('disabled', true);
  } else if (type == 'ward') {
    $(el + ' #ward_id').html('').select2({ data: { id: null, text: null } });
    $(el + ' #ward_id').append(new Option(null, '', false, false)).trigger('change.select2');
    $(el + ' #ward_id').prop('disabled', true);
  } else if (type == 'all') {
    $(el + ' #area_id, ' + el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').html('').select2({ data: { id: null, text: null } });
    $(el + ' #area_id, ' + el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').append(new Option(null, '', false, false)).trigger('change.select2');
    $(el + ' #area_id, ' + el + ' #province_id, ' + el + ' #district_id, ' + el + ' #ward_id').prop('disabled', true);
  }
}

var getSelectValue = function (e) {
  var values = [];
  $(e.currentTarget).find("option:selected").each(function (i, selected) {
    values[i] = $(selected).val();
  });
  return values;
}