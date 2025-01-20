# **Лампочки с управлением яркостью и теплотой цвета.**  
## **Простое устройство для MajorDomo.**   
Добавление в MajorDomo простого устройства для лампочек с управлением яркостью и теплотой цвета.   
Расширяет встроенный класс SDimmers.  
С авто режимом включеня по датчику освещения, восходу/закату солнца или по установленному времени.  
С заданными яркостью и теплотой для дня и ночи.  
Автовыключение через заданное времени.  
Авто режим для Дня, Ночи или в течении всего деня.  

**Привязка свойства:**  

- **levelWork - brightness лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/brightness  
- **cctWork - color_temp лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/color_temp  
- **status - state лампочки.**  
  - Добавить Путь (write): zigbee2mqtt/Название устройства/set/state  
  - Написать в Replace list: ON=1,OFF=0  
  - Указать минимальные и максимальные рабочие уровни для яркости и теплоты:  

**Для лампочек Xiaomi ZigBee**  

- maxWork - 254  
- minWork - 0  
- cctMaxWork - 370  
- cctMinWork - 153  

**Для для лампочек Tuta ZigBee**  

- maxWork - 254  
- minWork - 0  
- cctMaxWork - 500  
- cctMinWork - 153  

### **ОБЫЧНЫЙ РЕЖИМ:**  

Включить - callMethod('имя объекта '.'turnOn');  
Если без параметров установит то что в levelSaved и cctSeved.  
Если levelSaved и cctSeved пусто то на полную яркость(100%) и холодный цвет(0%).  

С параметрами:  
- callMethod('имя объекта.turnOn', array('level'=> 1<-->100, 'cctLevel'=> 0<-->100));  
- callMethod('имя объекта.turnOn', array('level'=> 1<-->100));  
- callMethod('имя объекта.turnOn', array('cctLevel'=> 0<-->100));  
  - Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.   

**Устанавливается flag=1. Стопер который не дает запускаться авто режиму и методу AutoOff.**  

### **АВТО РЕЖИМ:**  

Включить авто режим - callMethod('имя объекта.turnOn', array('autoMode'=>1)) - к пимеру запускать по датчику движения;   
- Включится на время которое указано в timerOff(сек). Если 0 то включится но сам не выключится.  
- Если в presence(например данные с датчика присутствия) 1 то не выключится.  
  - Как только в presence изменися с 1 на 0 запустится метод автовыключения(AutoOff).    
- Можно включать авто режим для Дня, Ночи или в течении всего деня.   
  - если в workingDay:   
    + 0 - Весь день.(Ночью ночные установки яркости и теплоты. Днем дневные.)  
    + 1 - Днем  (дневные установки)  
    + 2 - Ночью  (ночные установки)  
- Авто режим по времени (workingBy=1):  
    - после начало ночь - ночные установки яркости и теплоты.  
    - после начло день - дневные.  
- Авто режим по солнцу (workingBy=2):  
  - после захода - ночные установки яркости (nightLevel) и теплоты (nightCct).  
  - после восхода - дневные (dayLevel, dayCct).  
  - Надо обязательно писать в свойства sunriseTime и sunsetTime время восхода и заката.  
    Если не указано, то то, что указано - по времени.  
  - К восходу и закату можно прибавить или отнять время если надо чтобы включалось или выключалось раньше или позже:  
    - addTimeSunrise - к рассвету в формате 05:30 (5 часов 30 минут)  
      - signSunrise 0 - отнять 1 - прибавить.  
    - addTimeSunset  - к закату в формате 00:30 (30 минут)  
      - signSunset 0 - отнять 1 - прибавить.  
- Авто режим по датчику (workingBy=3):  
    - Только ночные установки яркости и теплоты.  
      (Если надо можно дописать разные установки для дня и ночи.)   
      (Надо подумать про адаптивный свет.(после покупки датчика света))  
    - В свойство illuminance надо писать данные с датчика освещения.  
      - если illuminance меньше чем установленно в illuminanceMax подсветка включится.  
    - ***Работу по датчику освещения не проверял так как не имеется в наличии.***   
- **Можно запустить авто режим с параметрами:**  
  - callMethod('имя объекта.turnOn', array('autoMode'=>1, 'level'=> 1<--> 100,'cctLevel'=> 0<-->100));  

## **МЕТОДЫ:**  

- **turnOn**   
  - Включить - callMethod('имя объекта '.'turnOn');  
    - Если без параметров установит то что в levelSaved и cctSeved.  
    - Если levelSaved и cctSeved пусто то на полную яркость(100%) и холодный цвет(0%).  
    - **Устанавливается flag=1. Стопер который не дает запускаться авто режиму и методу AutoOff.**  
    - С параметрами:  
      - callMethod('имя объекта.turnOn', array('level'=> 1<-->100, 'cctLevel'=> 0<-->100));  
      - callMethod('имя объекта.turnOn', array('level'=> 1<-->100));  
      - callMethod('имя объекта.turnOn', array('cctLevel'=> 0<-->100));  
      - Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.   
  - Включить авто режим - callMethod('имя объекта.turnOn', array('autoMode'=>1));   
    - С параметрами:
      - callMethod('имя объекта.turnOn', array('autoMode'=>1, 'level'=> 1<-->100, 'cctLevel'=> 0<-->100));  
      - callMethod('имя объекта.turnOn', array('autoMode'=>1, 'level'=> 1<-->100));  
      - callMethod('имя объекта.turnOn', array('autoMode'=>1, 'cctLevel'=> 0<-->100));  
      - Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.   
- **turnOff**  
  - Выключить - callMethod('имя объекта '.'turnOff');  
    - Устанавливается flag = 0
    - Устанавливается illuminanceFlag = 0
- **setLevel**   
  - Установить яркость света.(array("value"=> 0 <--> 100 %))  
    - **flag=1** - авто режим и автовыключение не запустится.  
- **setCct**   
  - Установить температуру.(array("value"=>0 <--> 100 %))  
    - Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.  
    - **flag=1** - авто режим и автовыключение не запустится.  
- **levelDown**  
  - Уменьшить яркость.(array("value"=>1--100)). Без  параметров -10.  
  - **flag=1** - авто режим и автовыключение не запустится.  
- **levelUp**  
  - Увеличить яркость.(array("value"=>1--100)). Без  параметров 10.  
  - **flag=1** - авто режим и автовыключение не запустится.  
- **cctDown**  
  - Уменьшить температуру.(array("value"=>1--100)). Без  параметров -10.  
  - **flag=1** - авто режим и автовыключение не запустится.  
- **cctUp**  
  - Увеличить температуру.(array("value"=>1--100)). Без  параметров 10.  
  - **flag=1** - авто режим и автовыключение не запустится.  
- **byDefault**  
  - Установит параметры по дефолту. Это если что-то пошло не так.  
    (При первом запуске метода turnOn тоже все выставится по дефолту.)  
- **commandsMenu**  
  - Создаст меню данного объекта в "Меню Управления"  

При первом запуске метода **turnOn** все нужные свойства для работы метода должны прописаться сами.  
Если нужны другие то можно изменить в ручную в свойствах объекта или запустить мктод commandsMenu.  
Он сам создаст меню в "**Меню Управления**" и там можно все удобно настроить.  
Меню будет называться по имени объекта. При желании можно изменить на любое другое.  

Было проверено на лампочках [Xiaomi ZigBee](https://www.zigbee2mqtt.io/devices/ZNLDP12LM.html#aqara-znldp12lm "zigbee2mqtt.io")  
И на потолочной лампе [Tuta ZigBee](https://www.zigbee2mqtt.io/devices/ZB-LZD10-RCW.html#moes-zb-lzd10-rc "zigbee2mqtt.io")  
