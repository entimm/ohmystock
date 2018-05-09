import sys
import tushare as ts

argv = sys.argv[1:]

try:
    code = argv[0]
except Exception as e:
    print('Code is required');
    exit(1)

date = argv[1]

df = ts.get_tick_data(code, date)

print(df.to_json(orient='records'))