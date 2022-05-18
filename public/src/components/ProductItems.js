import React from "react";

const ProductItems = (props) => {
  const { product, deleteIds, setDeleteIds } = props;

  const handleChange = (e) => {
    if (e.target.checked === true) {
      setDeleteIds([...deleteIds, e.target.value]);
    } else {
      setDeleteIds(deleteIds.filter((id) => id !== e.target.value));
    }
  };

  return (
    <div className="col-md-3 mb-4">
      <div className="card">
        <div className="card-body">
          <h5 className="card-subtitle">
            <input
              type="checkbox"
              className="delete-checkbox form-check-input"
              value={product.id}
              checked={deleteIds.includes(product.id)}
              onChange={(e) => handleChange(e)}
            />
          </h5>
          <span className="card-text text-center">
            <ul
              style={{
                listStyleType: "none",
                margin: 0,
                padding: 0,
              }}
            >
              <li>{product.SKU}</li>
              <li>{product.name}</li>
              <li>{product.price} $</li>
              <li>
                {product.size !== null && `Size: ${product.size} MB`}{" "}
                {product.weight !== null && `Weight: ${product.weight} KG`}{" "}
                {product.height !== null &&
                  `Dimension: ${product.height}X${product.width}X${product.length}`}
              </li>
            </ul>
          </span>
        </div>
      </div>
    </div>
  );
};

export default ProductItems;
