
// Modals
let modal;

const options = {
  placement: 'bottom-right',
  backdrop: 'dynamic',
  backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
  closable: true,
  onHide: () => {
      console.log('modal is hidden');
  },
  onShow: () => {
      console.log('modal is show');
  },
  onToggle: () => {
      console.log('modal has been toggled');
  }
};

function createModal(){
  if(modal == undefined) modal = new Modal(document.getElementById('authentication-modal'), options);
  
  document.getElementById('tittleModal').innerHTML = 'Nuevo Producto'; 

  document.getElementById('barcode').value = '';
  document.getElementById('name').value    = '';
  document.getElementById('brand').value   = '';
  document.getElementById('price').value   = '';
  document.getElementById('unit').value    = '';
  document.getElementById('stock').value   = '';

  $('#btnAdd').removeClass('hidden');
  $('#btnUpdate').addClass('hidden');

  modal.show();
}

// CRUD
function filterProducts() {
  let form = getForms('filtro');

  HTTPSRequest('filterProducts', form.inputsValue);
}

function searchProduct(id){
  formData = new FormData();
  formData.append('id', id);

  HTTPSRequest('searchProduct', formData);
}

function addProduct() {
  let form = getForms('formProduct');

  let formData = form.inputsValue;
  formData.append("image", document.getElementById('image').files[0])

  HTTPSRequest('add', formData);
}

function updateProduct() {
  let form = getForms('formProduct');

  let formData = form.inputsValue;
  formData.append("image", document.getElementById('image').files[0])

  HTTPSRequest('update', formData);
}

function deleteProduct(id, nombre){
  Swal.fire({
    title: 'Eliminar Producto',
    text: `¿Estás seguro de que quieres eliminar ${nombre}?`,
    confirmButtonColor: '#C70039',
    confirmButtonText: 'Aceptar',
    showCancelButton: true,
  }).then((result) => {
      if (result.isConfirmed) {
        formData = new FormData();
        formData.append('id', id);

        HTTPSRequest('destroy', formData);
      } 
  });

}


// Functions in general
function getForms(id) {
  let formData = new FormData(document.getElementById(`${id}`));
  let _json = { status: 0, inputsValue: formData, inputsEmpty: []}

  formData.forEach((value, index) => {
    if (!value) _json.inputsEmpty.push(`${index}`);
  })

  if (!_json.inputsEmpty.length) _json.status = 1 ;

  return _json;
}

function HTTPSRequest (action, data){
  url = document.getElementById('url').value;
  
  fetch(url + action, {
      method: "POST",
      body: data
  })
  .then(response => response.json())
  .then(response => {
    if (response.error != false) {
      return Swal.fire({
        icon: 'error',
        title: 'Error',
        text: response.message,
        showConfirmButton: false,
        timer: 2500
      });
    }

    if(response.result){
      if(modal == undefined) modal = new Modal(document.getElementById('authentication-modal'), options);
      
      // Tittle
      document.getElementById('tittleModal').innerHTML = 'Actualizar Producto';

      // Inputs
      document.getElementById('id').value      = response.result.id;
      document.getElementById('barcode').value = response.result.barcode;
      document.getElementById('name').value    = response.result.name;
      document.getElementById('brand').value   = response.result.brand;
      document.getElementById('price').value   = response.result.price;
      document.getElementById('unit').value    = response.result.unit;
      document.getElementById('stock').value   = response.result.stock;

      $('#btnAdd').addClass('hidden');
      $('#btnUpdate').removeClass('hidden');

      modal.show();

      return;
    } 

    document.getElementById('totalProducts').innerHTML = response.total;

    if(action == 'filterProducts'){
      document.getElementById('cardPrincipal').innerHTML = '';
      document.getElementById('containerCard').innerHTML = response.html;

      return;
    }

    Swal.fire({
      icon: 'success',
      title: '¡Información completa!',
      text: response.message,
      showConfirmButton: false,
      timer: 2000
    });

    document.getElementById('cardPrincipal').innerHTML = '';
    document.getElementById('containerCard').innerHTML = response.html;
    
    modal.hide();

    return;
  })
  .catch(error => console.error('Error:', error))
}