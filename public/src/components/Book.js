import React, { useEffect } from "react";

const Book = (props) => {
  const { weight, setWeight, invalid } = props;

  useEffect(() => {
    //A cleanup method to set props back to default on unmount
    return () => {
      setWeight("");
    };
  }, [setWeight]);
  return (
    <>
      <div className="row mb-3">
        <label htmlFor="weight" className="col-md-3 col-form-label">
          Weight (KG) <span className="text-danger">*</span>
        </label>
        <div className="col-md-9">
          <input
            type="number"
            className={`form-control ${
              invalid && weight === "" && "is-invalid"
            }`}
            id="weight"
            value={weight}
            onChange={(e) => setWeight(e.target.value)}
          />
          <div className="invalid-feedback">Weight is required.</div>
        </div>
      </div>

      <div className="row mb-3">
        <div className="col-md-12">
          <div className="alert alert-info">
            * Please provide book weight in KG.
          </div>
        </div>
      </div>
    </>
  );
};

export default Book;
