#!/usr/bin/python3.5
cities=["Quito","Cayambe","Cumbaya","Ibarra","Cuenca","Latacunga", "Guayaquil"]
import urllib.request
import psycopg2
import xml.etree.ElementTree as ET
import datetime
conn = psycopg2.connect("host=localhost dbname=munana user=webuser password=clav301$")
cur = conn.cursor()

for ciudad in cities:
    url_string ="http://api.openweathermap.org/data/2.5/weather?q="+ciudad+",Ec&mode=xml&units=metric&appid=57ba2a447f7909d8c2015c48e8a936b3"
    with urllib.request.urlopen(url_string) as response:
        xml_string = response.read()

    root = ET.fromstring(xml_string)
    rg=[]
    
    c = root.find("./city")
    rg.append(c.attrib["name"])

    c = root.find("./city/sun")
    rg.append(c.attrib["rise"])
    rg.append(c.attrib["set"])

    c = root.find("./temperature")
    rg.append (float(c.attrib["value"]))

    c = root.find("./humidity")
    rg.append (float(c.attrib["value"]))

    c = root.find("./pressure")
    rg.append (float(c.attrib["value"]))

    c = root.find("./wind/speed")
    rg.append (float(c.attrib["value"]))

    c = root.find("./wind/direction")
    rg.append (c.attrib["name"]+" ("+str(c.attrib["value"])+"°) ")

    c = root.find("./clouds")
    rg.append (float(c.attrib["value"]))

    c = root.find("./clouds")
    rg.append (c.attrib["name"])

    c = root.find("./visibility")
    if "value" in c.attrib:
        rg.append(c.attrib["value"])
    else:    
        rg.append (-1)

    c = root.find("./precipitation")
    rg.append (c.attrib["mode"])
    if c.attrib["mode"] =="no": rg.append(0.0)
    else:
        c = root.find("./precipitation")
        rg.append (float(c.attrib["value"]))

    c = root.find("./weather")
    rg.append (c.attrib["value"])

    c = root.find("./weather")
    rg.append (c.attrib["icon"])

    c = root.find("./lastupdate")
    rg.append (c.attrib["value"])
    
    rg.append("OK")
    
    fechahora = datetime.datetime.now().strftime('%Y-%m-%dT%H:%M:%S')
    rg.append(str(fechahora))

    c = root.find("./city")
    rg.append(int(c.attrib["id"]))

    cur.execute("""INSERT INTO t_clima(ciudad,risesun,setsun,temperatura,humedad,
    presion,vientospeed,vientodir,nubes,nubesname,visibilidad,lluvia,precipitacion,
    valorclima,iconclima,tiempo,vigente,lectura,ciudadid) 
    VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)""",rg)
    conn.commit()
    print("OK", ciudad)

cur.close()
conn.close()

