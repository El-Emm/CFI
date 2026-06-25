/**
 * Field Media admin — image and video upload controls.
 */
(function ($) {
  'use strict';

  function openMediaFrame(options) {
    const frame = wp.media({
      title: options.title,
      button: { text: options.button },
      library: options.library || {},
      multiple: false,
    });

    frame.on('select', function () {
      const attachment = frame.state().get('selection').first().toJSON();
      options.onSelect(attachment);
    });

    frame.open();
  }

  function bindImageField($field) {
    const $input = $field.find('[data-cfi-image-id]');
    const $preview = $field.find('[data-cfi-image-preview]');
    const $remove = $field.find('[data-cfi-image-remove]');

    $field.find('[data-cfi-image-upload]').on('click', function (e) {
      e.preventDefault();
      openMediaFrame({
        title: cfiFieldMedia.i18n.selectImage,
        button: cfiFieldMedia.i18n.useImage,
        library: { type: 'image' },
        onSelect(attachment) {
          $input.val(attachment.id);
          const url = attachment.sizes?.medium?.url || attachment.url;
          $preview.html(
            '<img src="' + url + '" alt="" style="max-width:240px;height:auto;border-radius:8px;display:block">'
          );
          $remove.show();
        },
      });
    });

    $remove.on('click', function (e) {
      e.preventDefault();
      $input.val('');
      $preview.empty();
      $remove.hide();
    });
  }

  function bindPosterField($field) {
    const $input = $field.find('[data-cfi-poster-id]');
    const $preview = $field.find('[data-cfi-poster-preview]');
    const $remove = $field.find('[data-cfi-poster-remove]');

    $field.find('[data-cfi-poster-upload]').on('click', function (e) {
      e.preventDefault();
      openMediaFrame({
        title: cfiFieldMedia.i18n.selectPoster,
        button: cfiFieldMedia.i18n.usePoster,
        library: { type: 'image' },
        onSelect(attachment) {
          $input.val(attachment.id);
          const url = attachment.sizes?.medium?.url || attachment.url;
          $preview.html(
            '<img src="' + url + '" alt="" style="max-width:240px;height:auto;border-radius:8px;display:block">'
          );
          $remove.show();
        },
      });
    });

    $remove.on('click', function (e) {
      e.preventDefault();
      $input.val('');
      $preview.empty();
      $remove.hide();
    });
  }

  function bindVideoField($field) {
    const $input = $field.find('[data-cfi-video-id]');
    const $preview = $field.find('[data-cfi-video-preview]');
    const $remove = $field.find('[data-cfi-video-remove]');

    $field.find('[data-cfi-video-upload]').on('click', function (e) {
      e.preventDefault();
      openMediaFrame({
        title: cfiFieldMedia.i18n.selectVideo,
        button: cfiFieldMedia.i18n.useVideo,
        library: { type: 'video' },
        onSelect(attachment) {
          $input.val(attachment.id);
          $preview.html('<code>' + attachment.filename + '</code>');
          $remove.show();
        },
      });
    });

    $remove.on('click', function (e) {
      e.preventDefault();
      $input.val('');
      $preview.empty();
      $remove.hide();
    });
  }

  function toggleTypeFields() {
    const type = $('#cfi_media_type').val();
    $('#cfi-image-fields').toggle(type === 'image');
    $('#cfi-video-fields').toggle(type === 'video');
  }

  $(function () {
    if (!$('#cfi-field-media-box').length) {
      return;
    }

    bindImageField($('#cfi-image-fields'));
    bindPosterField($('#cfi-poster-fields'));
    bindVideoField($('#cfi-video-fields'));

    $('#cfi_media_type').on('change', toggleTypeFields);
    toggleTypeFields();
  });
})(jQuery);
