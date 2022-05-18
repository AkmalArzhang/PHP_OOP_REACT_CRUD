import React, { useEffect } from "react";

const Furniture = (props) => {
  const { height, setHeight, width, setWidth, length, setLength, invalid } =
    props;

  useEffect(() => {
    //A cleanup method to set props back to default on unmount
    return () => {
      setHeight("");
      setWidth("");
      setLength("");
    };
  }, [setHeight, setLength, setWidth]);
  return (
    <>
      <div className="row mb-3">
        <label htmlFor="height" className="col-md-3 col-form-label">
          Height (CM) <span className="text-danger">*</span>
        </label>
        <div className="col-md-9">
          <input
            type="number"
            className={`form-control ${
              invalid && height === "" && "is-invalid"
            }`}
            id="height"
            value={height}
            onChange={(e) => setHeight(e.target.value)}
          />
          <div className="invalid-feedback">Height is required.</div>
        </div>
      </div>
      <div className="row mb-3">
        <label htmlFor="width" className="col-md-3 col-form-label">
          Width (CM) <span className="text-danger">*</span>
        </label>
        <div className="col-md-9">
          <input
            type="number"
            className={`form-control ${
              invalid && width === "" && "is-invalid"
            }`}
            id="width"
            value={width}
            onChange={(e) => setWidth(e.target.value)}
          />
          <div className="invalid-feedback">Width is required.</div>
        </div>
      </div>
      <div className="row mb-3">
        <label htmlFor="length" className="col-md-3 col-form-label">
          Length (CM) <span className="text-danger">*</span>
        </label>
        <div className="col-md-9">
          <input
            type="number"
            className={`form-control ${
              invalid && length === "" && "is-invalid"
            }`}
            id="length"
            value={length}
            onChange={(e) => setLength(e.target.value)}
          />
          <div className="invalid-feedback">Length is required.</div>
        </div>
      </div>

      <div className="row mb-3">
        <div className="col-md-12">
          <div className="alert alert-info">
            * Please provide furniture dimensions in HXWXL.
          </div>
        </div>
      </div>
    </>
  );
};

export default Furniture;
