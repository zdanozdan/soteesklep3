USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_50%22"))
insDoc(aux1, gLnk("S","Adapta","/go/_category/?idc=%2250_12288%22"))
insDoc(aux1, gLnk("S","Agar","/go/_category/?idc=%2250_12315%22"))
insDoc(aux1, gLnk("S","Gumki polerskie","/go/_category/?idc=%2250_12287%22"))
insDoc(aux1, gLnk("S","Kamienie , Tarcze , Separatory","/go/_category/?idc=%2250_12299%22"))
aux2 = insFld(aux1, gFld("Masy os³aniaj±ce","/go/_category/?idc=%2250_12292%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2250_12292_277%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2250_12292_276%22"))
aux2 = insFld(aux1, gFld("Metale","/go/_category/?idc=%2250_12291%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2250_12291_277%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2250_12291_276%22"))
insDoc(aux1, gLnk("S","P³yny do utwardzania modeli","/go/_category/?idc=%2250_12336%22"))
insDoc(aux1, gLnk("S","Preparaty do gipsu , wosku","/go/_category/?idc=%2250_12297%22"))
insDoc(aux1, gLnk("S","Szczotki , Filce","/go/_category/?idc=%2250_12295%22"))
aux2 = insFld(aux1, gFld("Woski","/go/_category/?idc=%2250_12285%22"))
insDoc(aux2, gLnk("S","Woski do modelowania","/go/_category/?idc=%2250_12285_275%22"))
insDoc(aux2, gLnk("S","Woski na protezy szkieletowe","/go/_category/?idc=%2250_12285_278%22"))
