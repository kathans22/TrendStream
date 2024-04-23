(function($) {
    showSwal = function(type,title,text,btntext) {
      'use strict';
      if (type === 'basic') {
        swal({
          text: 'Any fool can use a computer',
          button: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        })
  
      } else if (type === 'title-and-text') {
        swal({
          title: 'Read the alert!',
          text: 'Click OK to close this alert',
          button: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        })
  
      } else if (type === 'success-message') {
        swal({
          title: title,
          text: text,
          icon: 'success',
          button: {
            text: btntext,
            value: true,
            visible: true,
            className: "btn btn-primary btn-sm"
          }
        })
  
      } else if (type === 'auto-close') {
        swal({
          title: title,
          text: text,
          timer: 2000,
          button: false
        }).then(
          function() {},
          // handling the promise rejection
          function(dismiss) {
            if (dismiss === 'timer') {
              console.log('I was closed by the timer')
            }
          }
        )
      } else if (type === 'warning-message-and-cancel') {
        swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3f51b5',
          cancelButtonColor: '#ff4081',
          confirmButtonText: 'Great ',
          buttons: {
            cancel: {
              text: "Cancel",
              value: null,
              visible: true,
              className: "btn btn-danger btn-sm",
              closeModal: true,
            },
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "btn btn-primary btn-sm",
              closeModal: true
            }
          }
        }).then((result)=>{
            if(result.isConfirm){
                return true;
            }
        })
  
      } else if (type === 'custom-html') {
        swal({
          content: {
            element: "input",
            attributes: {
              placeholder: "Enter read list name",
              type: "text",
              id:"id1",
              class: 'form-control'
            },
          },
          button: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        })
      }
    }
  
  })(jQuery);