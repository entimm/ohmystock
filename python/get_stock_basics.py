import tushare as ts

df = ts.get_stock_basics()

print(df.to_json(orient='index'))