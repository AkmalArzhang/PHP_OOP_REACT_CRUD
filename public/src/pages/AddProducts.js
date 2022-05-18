import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import Book from "../components/Book";
import Furniture from "../components/Furniture";
import DVD from "../components/DVD";
import { createProduct } from "../services/productServices";

const AddProducts = () => {
  const navigate = useNavigate();

  //Main Form
  const [productType, setProductType] = useState("");
  const [SKU, setSKU] = useState("");
  const [name, setName] = useState("");
  const [price, setPrice] = useState("");

  //DVD Component
  const [size, setSize] = useState("");

  //Book Component
  const [weight, setWeight] = useState("");

  //Furniture Component
  const [height, setHeight] = useState("");
  const [width, setWidth] = useState("");
  const [length, setLength] = useState("");

  //Invalid Fields
  const [invalid, setInvalid] = useState(false);
  const [invalidSKU, setInvalidSKU] = useState(false);

  //Save Button
  const [save, setSave] = useState({
    text: "Save",
    disabled: false,
  });

  //Compnents List, Related Props and Required validation inputs
  const productTypeComponents = {
    dvd_disc: {
      component: DVD,
      props: { size: size, setSize: setSize },
      validate: { size: size },
    },
    furnitures: {
      component: Furniture,
      props: {
        height: height,
        setHeight: setHeight,
        width: width,
        setWidth: setWidth,
        length: length,
        setLength: setLength,
      },
      validate: { height: height, width: width, length: length },
    },
    books: {
      component: Book,
      props: { weight: weight, setWeight: setWeight },
      validate: { weight: weight },
    },
  };

  let SelectedProductType = false;

  if (productType !== "") {
    SelectedProductType = productTypeComponents[productType]["component"];
  }

  const validateInput = (inputs) => {
    let validation = true;

    Object.keys(inputs).map((key) => {
      if (inputs[key] === "") {
        validation = false;
      }

      return validation;
    });

    return validation;
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const inputs = {
      SKU: SKU,
      name: name,
      price: price,
      type: productType,
    };

    if (productType !== "") {
      const validateProductTypes =
        productTypeComponents[productType]["validate"];
      for (const key in validateProductTypes) {
        inputs[key] = validateProductTypes[key];
      }
    }

    if (!validateInput(inputs)) {
      setInvalid(true);
      return;
    }

    setSave({
      text: "Loading...",
      disabled: true,
    });

    setInvalid(false);

    createProduct(inputs).then((response) => {
      if (response.status === 201) {
        navigate("/");
      } else {
        setInvalidSKU(true);
      }

      setSave({
        text: "Save",
        disabled: false,
      });
    });
  };

  return (
    <form
      id="product_form"
      onSubmit={(e) => handleSubmit(e)}
      autoComplete="off"
    >
      <div className="container mt-4">
        <div className="row border-bottom border-2 border-primary pb-3">
          <div className="col-md-6">
            <h3>Product Add</h3>
          </div>
          <div className="col-md-6 ms-auto">
            <div className="d-grid gap-2 d-md-flex justify-content-md-end">
              <button
                className="btn btn-primary me-md-2"
                disabled={save.disabled}
                type="submit"
              >
                {save.text}
              </button>

              <Link
                to="/"
                className="btn btn-secondary"
                type="button"
                id="delete-product-btn"
              >
                Cancel
              </Link>
            </div>
          </div>
        </div>
        <div className="row mt-4">
          <div className="col-md-6">
            <div className="form">
              {invalid && (
                <div className="row mb-3">
                  <div className="col-md-12">
                    <div className="alert alert-danger">
                      Please, submit required data
                    </div>
                  </div>
                </div>
              )}
              {invalidSKU && (
                <div className="row mb-3">
                  <div className="col-md-12">
                    <div className="alert alert-danger">
                      SKU already taken! Or some errors occured on the server.
                    </div>
                  </div>
                </div>
              )}
              <div className="row mb-3">
                <label htmlFor="sku" className="col-md-3 col-form-label">
                  SKU <span className="text-danger">*</span>
                </label>
                <div className="col-md-9">
                  <input
                    type="text"
                    className={`form-control ${
                      invalid && SKU === "" && "is-invalid"
                    }`}
                    id="sku"
                    value={SKU}
                    onChange={(e) => setSKU(e.target.value)}
                  />
                  <div className="invalid-feedback">
                    SKU is required. Please provide a unique SKU.
                  </div>
                </div>
              </div>
              <div className="row mb-3">
                <label htmlFor="name" className="col-md-3 col-form-label">
                  Name <span className="text-danger">*</span>
                </label>
                <div className="col-md-9">
                  <input
                    type="text"
                    className={`form-control ${
                      invalid && name === "" && "is-invalid"
                    }`}
                    id="name"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                  />
                  <div className="invalid-feedback">Name is required.</div>
                </div>
              </div>
              <div className="row mb-3">
                <label htmlFor="price" className="col-md-3 col-form-label">
                  Price ($) <span className="text-danger">*</span>
                </label>
                <div className="col-md-9">
                  <input
                    type="number"
                    className={`form-control ${
                      invalid && price === "" && "is-invalid"
                    }`}
                    id="price"
                    step="0.01"
                    value={price}
                    onChange={(e) => setPrice(e.target.value)}
                  />
                  <div className="invalid-feedback">Price is required.</div>
                </div>
              </div>
              <div className="row mb-3">
                <label
                  htmlFor="productType"
                  className="col-md-3 col-form-label"
                >
                  Type Switcher <span className="text-danger">*</span>
                </label>
                <div className="col-md-9">
                  <select
                    className={`form-control ${
                      invalid && productType === "" && "is-invalid"
                    }`}
                    id="productType"
                    value={productType}
                    onChange={(e) => setProductType(e.target.value)}
                  >
                    <option value="">Type Switcher</option>
                    <option value="dvd_disc" id="DVD">
                      DVD
                    </option>
                    <option value="furnitures" id="Furniture">
                      Furniture
                    </option>
                    <option value="books" id="Book">
                      Book
                    </option>
                  </select>
                  <div className="invalid-feedback">Please select a type.</div>
                </div>
              </div>
              {/* Dynamically load related components based on Type Switcher value */}
              {SelectedProductType && <hr />}
              {SelectedProductType && (
                <SelectedProductType
                  {...productTypeComponents[productType]["props"]}
                  invalid={invalid}
                  productType={productType}
                />
              )}
            </div>
          </div>
        </div>
      </div>
    </form>
  );
};

export default AddProducts;
