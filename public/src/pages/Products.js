import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import ProductItems from "../components/ProductItems";
import { deleteProducts, listAllProducts } from "../services/productServices";

const Products = () => {
  const [productsList, setProductsList] = useState([]);
  const [deleteIds, setDeleteIds] = useState([]);
  const [deleteButton, setDeleteButton] = useState({
    text: "MASS DELETE",
    disabled: false,
  });

  useEffect(() => {
    listAllProducts().then((response) => {
      if (response.status === 200) {
        setProductsList(response.data);
      }
    });
  }, []);

  const handleDeleteButton = () => {
    if (deleteIds.length <= 0) return;

    setDeleteButton({
      text: "LOADING...",
      disabled: true,
    });

    deleteProducts(deleteIds).then((response) => {
      setDeleteIds([]);
      if (response.status === 200) {
        setProductsList(
          productsList.filter(
            (product) => !response.data.deleted_ids.includes(product.id)
          )
        );
      }

      setDeleteButton({
        text: "MASS DELETE",
        disabled: false,
      });
    });
  };

  return (
    <div className="container mt-4">
      <div className="row border-bottom border-2 border-primary pb-3">
        <div className="col-md-6">
          <h3>Product List</h3>
        </div>
        <div className="col-md-6 ms-auto">
          <div className="d-grid gap-2 d-md-flex justify-content-md-end">
            <Link to="/add-product">
              <button className="btn btn-primary me-md-2" type="button">
                ADD
              </button>
            </Link>
            <button
              id="delete-product-btn"
              className="btn btn-danger"
              type="button"
              disabled={deleteButton.disabled === false ? "" : "disabled"}
              onClick={() => handleDeleteButton()}
            >
              {deleteButton.text}
            </button>
          </div>
        </div>
      </div>
      <div className="row mt-4">
        {productsList.map((product) => (
          <ProductItems
            product={product}
            deleteIds={deleteIds}
            setDeleteIds={setDeleteIds}
            key={product.id}
          />
        ))}
      </div>
    </div>
  );
};

export default Products;
