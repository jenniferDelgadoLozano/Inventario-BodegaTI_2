window.addEventListener('DOMContentLoaded', () => {
  const search = document.querySelector('#search')
  const tableContainer = document.querySelector('#resultado tbody')
  const resultadoContainer = document.querySelector('#resultadoContainer') //con numeral porque es un id
  const errorsContainer = document.querySelector('.errors-container') //con punto y guion porque es una clase
  let criterio_busqueda = ''
  
  if(search) {
    search.addEventListener('input', event => {
      criterio_busqueda = event.target.value.toUpperCase()
      showResults()
    })
  }
  
  //envio de peticion usando fetch
  const searchData = async () => {
    let searchData = new FormData()
    searchData.append('criterio_busqueda', criterio_busqueda)
    try {
      const response = await fetch('search_data.php', {
        method: 'POST',
        body: searchData
      })
      return response.json()
    } catch (error) {
      alert(`${'Hubo un error'}${error.message}`)
      console.log(error)
    }
  }

  //funcion para mostrar los datos
  const showResults = () => {
    searchData()
    .then(dataResults => {
      console.log(dataResults)
      tableContainer.innerHTML = ''
      if(typeof dataResults.data !== 'undefined' && !dataResults.data) {
        errorsContainer.style.display = 'block'
        errorsContainer.querySelector('p').innerHTML = `
        No hay resultados para este criterio de busqueda: <span style="color: #FA1200">${criterio_busqueda}</span>`
        resultadoContainer.style.display = 'none'
      } else {
        resultadoContainer.style.display = 'block'
        errorsContainer.style.display = 'none'
        for (const products of dataResults) {
          const row = document.createElement('tr')
          row.innerHTML = `
          <td class="text-center">${products.codigo}</td>
          <td class="text-center">${products.date}</td>
          <td class="text-center">${products.name}</td>
          <td class="text-center">${products.movimiento}</td>
          <td class="text-center">${products.estados}</td>
          <td class="text-center">${products.entrada}</td>
          <td class="text-center">${products.salida}</td>
          <td class="text-center">${products.stock}</td>
          <td class="text-center">${products.ubicacion}</td>
          `
          tableContainer.appendChild(row)
        }
      }
    })
  }
  showResults()
})
// _____________________________________________________________________________________________________________________________________________________________________
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="remove-icon.png"/></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

// _____________________________________________________________________________________________________________________________________________________________________
  if(window.history.replaceState) {
    console.log("¡Ya Ingreso!")
    window.history.replaceState(null, null, window.location.href)
  }

