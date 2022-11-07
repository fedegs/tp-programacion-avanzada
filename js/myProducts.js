const buttonsClose = document.querySelectorAll("#closeModalProduct")
const btnAddProduct = document.querySelector("#btnAddProduct")
const modalProduct = document.querySelector("#modalProduct")
const modalEditProduct = document.querySelector("#modalEditProduct")

function openEditModal(id, title, description, price, category) {
  modalEditProduct.setAttribute("open", true)

  const form = modalEditProduct.querySelector("form")
  modalEditProduct.querySelector("input[name='title'").value = title
  modalEditProduct.querySelector("input[name='price'").value = price
  modalEditProduct.querySelector("textarea[name='description'").value =
    description
  const options = modalEditProduct.querySelectorAll("option")
  options.forEach((opt) => {
    if (opt.getAttribute("value") === "") {
      opt.removeAttribute("selected")
    } else {
      if (opt.text === category) {
        opt.setAttribute("selected", true)
      }
    }
  })

  const hiddenInput = document.createElement("input")
  hiddenInput.setAttribute("type", "hidden")
  hiddenInput.setAttribute("value", id)
  hiddenInput.setAttribute("name", "id")
  form.appendChild(hiddenInput)
}

btnAddProduct.addEventListener("click", () => {
  modalProduct.setAttribute("open", true)
})

buttonsClose.forEach((btn) =>
  btn.addEventListener("click", () => {
    modalEditProduct.removeAttribute("open")
    modalProduct.removeAttribute("open")
  })
)

const tabla = document.querySelector("#tabla")
const dataTable = new DataTable(tabla)

const inputs = document.querySelectorAll("input[name]")
const selects = document.querySelectorAll("select[name]")

inputs.forEach((i) => {
  i.addEventListener("invalid", () => {
    i.setAttribute("aria-invalid", true)
  })
  i.addEventListener("input", () => {
    i.removeAttribute("aria-invalid")
  })
})

selects.forEach((s) => {
  s.addEventListener("invalid", () => {
    s.setAttribute("aria-invalid", true)
  })
  s.addEventListener("input", () => {
    s.removeAttribute("aria-invalid")
  })
})
