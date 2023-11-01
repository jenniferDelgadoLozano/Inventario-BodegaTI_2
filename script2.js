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
      const response = await fetch('search_data2.php', {
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
          <td class="text-center">${products.codigo.toUpperCase().replace(criterio_busqueda, '<span class="bold">$&</span>')}</td>
          `
          tableContainer.appendChild(row)
        }
      }
    })
  }
  // showResults()
})
// _____________________________________________________________________________________________________________________________________________________________________
  if(window.history.replaceState) {
    console.log("¡Ya Ingreso!")
    window.history.replaceState(null, null, window.location.href)
  }