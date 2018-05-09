import sys
import tushare as ts

argv = sys.argv[1:]

try:
    code = argv[0]
except Exception as e:
    print('Code is required');
    exit(1)

df = ts.get_realtime_quotes(code)

print(df.to_json(orient='records'))