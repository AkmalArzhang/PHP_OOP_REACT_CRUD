import React, { useEffect } from "react";

const DVD = (props) => {
  const { size, setSize, invalid } = props;

  useEffect(() => {
    //A cleanup method to set props back to default
    return () => {
      setSize("");
    };
  }, [setSize]);
  return (
    <>
      <div className="row mb-3">
        <label htmlFor="size" className="col-md-3 col-form-label">
          Size (MB) <span className="text-danger">*</span>
        </label>
        <div className="col-md-9">
          <input
            type="number"
            className={`form-control ${invalid && size === "" && "is-invalid"}`}
            id="size"
            value={size}
            onChange={(e) => setSize(e.target.value)}
          />
          <div className="invalid-feedback">Size is required.</div>
        </div>
      </div>

      <div className="row mb-3">
        <div className="col-md-12">
          <div className="alert alert-info">
            * Please provide DVD Size in MB.
          </div>
        </div>
      </div>
    </>
  );
};

export default DVD;
