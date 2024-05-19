import logging
import json
import azure.functions as func
from transformers import AutoTokenizer, AutoModel
import numpy as np

model_name = 'bert-base-german-cased'
tokenizer = AutoTokenizer.from_pretrained(model_name)
model = AutoModel.from_pretrained(model_name)

def text_to_vector(text):
    inputs = tokenizer(text, return_tensors='pt', truncation=True, padding=True, max_length=512)
    outputs = model(**inputs)
    # Use the embeddings of the [CLS] token
    vector = outputs.last_hidden_state[:, 0, :].detach().numpy()
    return vector.tolist()

app = func.FunctionApp(http_auth_level=func.AuthLevel.ANONYMOUS)

@app.route(route="bert_trigger")

def bert_trigger(req: func.HttpRequest) -> func.HttpResponse:
    logging.info('Python HTTP trigger function processed a request.')

    try:
        req_body = req.get_json()
        text = req_body.get('text')
    except ValueError:
        return func.HttpResponse(
            "Invalid input",
            status_code=400
        )
    
    if text:
        vector = text_to_vector(text)
        return func.HttpResponse(
            json.dumps(vector),
            mimetype="application/json",
            status_code=200
        )
    else:
        return func.HttpResponse(
            "Please pass text in the request body",
            status_code=400
        )