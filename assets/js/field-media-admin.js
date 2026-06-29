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
      multiple: options.multiple ? 'add' : false,
    });

    frame.on('select', function () {
      const selection = frame.state().get('selection');
      if (options.multiple) {
        options.onSelect(selection.toArray().map((model) => model.toJSON()));
      } else {
        options.onSelect(selection.first().toJSON());
      }
    });

    frame.open();
  }

  function renderImagePreviews($preview, ids) {
    if (!ids.length) {
      $preview.empty();
      return;
    }

    const items = ids.map((id) => {
      const attachment = wp.media.attachment(id);
      attachment.fetch();
      const url = attachment.get('sizes')?.medium?.url || attachment.get('url') || '';
      return `
        <figure class="cfi-field-media-thumb" data-id="${id}">
          <img src="${url}" alt="">
          <button type="button" class="cfi-field-media-thumb__remove" data-remove-id="${id}" aria-label="Remove image">&times;</button>
        </figure>`;
    });

    $preview.html(`<div class="cfi-field-media-thumb-grid">${items.join('')}</div>`);

    $preview.find('.cfi-field-media-thumb__remove').on('click', function (e) {
      e.preventDefault();
      const removeId = Number($(this).data('remove-id'));
      const $input = $('#cfi-image-fields [data-cfi-image-ids]');
      const next = $input.val()
        .split(',')
        .map((v) => Number(v))
        .filter((id) => id && id !== removeId);
      $input.val(next.join(','));
      renderImagePreviews($preview, next);
      $('#cfi-image-fields [data-cfi-image-remove]').toggle(next.length > 0);
    });
  }

  function bindImageField($field) {
    const $input = $field.find('[data-cfi-image-ids]');
    const $preview = $field.find('[data-cfi-image-preview]');
    const $remove = $field.find('[data-cfi-image-remove]');

    const initial = $input.val()
      .split(',')
      .map((v) => Number(v))
      .filter(Boolean);
    if (initial.length) {
      renderImagePreviews($preview, initial);
      $remove.show();
    }

    $field.find('[data-cfi-image-upload]').on('click', function (e) {
      e.preventDefault();
      openMediaFrame({
        title: cfiFieldMedia.i18n.selectImages,
        button: cfiFieldMedia.i18n.useImages,
        library: { type: 'image' },
        multiple: true,
        onSelect(attachments) {
          const current = $input.val()
            .split(',')
            .map((v) => Number(v))
            .filter(Boolean);
          const merged = current.slice();
          attachments.forEach((attachment) => {
            if (!merged.includes(attachment.id)) {
              merged.push(attachment.id);
            }
          });
          $input.val(merged.join(','));
          renderImagePreviews($preview, merged);
          $remove.toggle(merged.length > 0);
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
        multiple: false,
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
        multiple: false,
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
