const soundClips = document.querySelector('.sound-clips');
const mainSection = document.querySelector('.main-controls');
var id_stop = '';

if (navigator.mediaDevices.getUserMedia) {
  const constraints = { audio: true };
  let chunks = [];

  let onSuccess = function(stream) {
    const mediaRecorder = new MediaRecorder(stream);

    $(document).on("click", ".record", function (e) {
      e.preventDefault();
      var id = $(this).attr('data-id');

      mediaRecorder.start();

      $(this).addClass('d-none');
      $('#unmic_' + id).removeClass('d-none');
    });

    $(document).on("click", ".stop", function (e) {
      e.preventDefault();
      var id = $(this).attr('data-id');
      id_stop = id;

      mediaRecorder.stop();

      $(this).addClass('d-none');
      $('#mic_' + id).removeClass('d-none');
    });

    mediaRecorder.onstop = function(e) {
      const clipContainer = document.createElement('article');
      const audio = document.createElement('audio');

      clipContainer.classList.add('clip');
      audio.setAttribute('controls', '');

      clipContainer.appendChild(audio);
      $('#sound_' + id_stop).html(clipContainer);

      audio.muted = false;
      audio.controls = true;
      // audio.controlsList = "nodownload";
      const blob = new Blob(chunks, { 'type' : 'audio/ogg; codecs=opus' });
      chunks = [];
      const audioURL = window.URL.createObjectURL(blob);
      audio.src = audioURL;

      var fd = new FormData();
          fd.append("audio_data", blob);
          fd.append('test', test);
          fd.append('group', group);
          fd.append('question', id_stop);

      var xhr = new XMLHttpRequest();
          xhr.open("POST", base_api + "/examination/record?token=" + _token, true);
          xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
          xhr.send(fd);
    }

    mediaRecorder.ondataavailable = function(e) {
      chunks.push(e.data);
    }
  }

  let onError = function(err) {
    console.log('The following error occured: ' + err);
  }

  navigator.mediaDevices.getUserMedia(constraints).then(onSuccess, onError);

} else {
   console.log('getUserMedia not supported on your browser!');
}