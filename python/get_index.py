import tushare as ts

df = ts.get_index()

print(df.to_json(orient='records'))