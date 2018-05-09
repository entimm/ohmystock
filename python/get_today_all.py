import tushare as ts

df = ts.get_today_all()

print(df.to_json(orient='records'))