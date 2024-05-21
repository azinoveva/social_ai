# Import necessary functions and libraries
import azure.functions as func
import logging
import json
from transformers import AutoTokenizer, AutoModel
import numpy

# Load the BERT model and tokenizer for German language
model_name = 'bert-base-german-cased'
tokenizer = AutoTokenizer.from_pretrained(model_name)
model = AutoModel.from_pretrained(model_name)

# Define a function that converts text to vector using BERT embeddings
def text_to_vector(text):
    # Tokenize the text and convert it to PyTorch tensors
    inputs = tokenizer(text, return_tensors='pt', truncation=True, padding=True, max_length=512)
    
    # Pass the input tensors through the BERT model
    outputs = model(**inputs)
    
    # Extract the embeddings of the [CLS] token
    vector = outputs.last_hidden_state[:, 0, :].detach().numpy()
    
    # Convert the vector to a list and return it
    return vector.tolist()

app = func.FunctionApp(http_auth_level=func.AuthLevel.ANONYMOUS)

# Define the Azure Function route and its associated function
@app.route(route="http_trigger")
def http_trigger(req: func.HttpRequest) -> func.HttpResponse:
    """
    Azure HTTP trigger function that processes a request and returns a JSON response.

    Args:
        req (func.HttpRequest): The HTTP request object.

    Returns:
        func.HttpResponse: The HTTP response object.

    Raises:
        None
    """

    # Log a message to indicate that the function has been triggered
    logging.info('Python HTTP trigger function processed a request.')

    # Get the JSON body from the request
    req_body = req.get_json()

    # Extract the 'text' field from the JSON body
    text = req_body.get('text')
    
    # Check if the 'text' field is present
    if text:
        # Convert the text to a vector using the 'text_to_vector' function
        vector = text_to_vector(text)

        # Return a JSON response with the vector
        return func.HttpResponse(
            json.dumps(vector),
            mimetype="application/json",
            status_code=200
        )
    else:
        # Return an error response if the 'text' field is missing
        return func.HttpResponse(
            "Please pass text in the request body",
            status_code=400
        )