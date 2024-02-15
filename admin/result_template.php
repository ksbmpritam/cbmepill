<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Latest compiled and minified CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
    />
    <title>Result</title>

    <style>
      body {
        background-color: #eee;
      }

      label.radio {
        cursor: pointer;
      }

      label.radio input {
        position: absolute;
        top: 0;
        left: 0;
        visibility: hidden;
        pointer-events: none;
      }

      label.radio span {
        padding: 4px 0px;
        border: 1px solid red;
        display: inline-block;
        color: red;
        width: 100px;
        text-align: center;
        border-radius: 3px;
        margin-top: 7px;
        text-transform: uppercase;
      }

      label.radio input:checked + span {
        border-color: red;
        background-color: red;
        color: #fff;
      }

      .ans {
        margin-left: 36px !important;
      }

      .btn:focus {
        outline: 0 !important;
        box-shadow: none !important;
      }

      .btn:active {
        outline: 0 !important;
        box-shadow: none !important;
      }
    </style>
  </head>
  <body>
    <div class="container mt-5">
      <div class="d-flex justify-content-center row">
        <div class="col-md-10 col-lg-10">
          <div class="border">
            <div class="question bg-white p-3 border-bottom">
            </div>
            
            <div class="question bg-white p-3 border-bottom">
                
              <div class="d-flex flex-row align-items-center question-title">
                <h3 class="text-danger">Q.</h3>
                <h5 class="mt-1 ml-2">
                  Which of the following country has largest population?
                </h5>
              </div>

              <div class="ans ml-2">
                <label class="radio">
                  <span>1. Test</span>
                </label>
              </div>
              
            </div>
            
            
            
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
