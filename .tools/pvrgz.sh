#!/bin/bash
set -ue
PVR="${1}"
PNG="$(echo "${PVR}" | sed 's/pvr$/png/')"
gunzip < "${PVR}" > tmp.pvr
.tools/PVRTexToolCLI -d -i tmp.pvr
mv tmp_Out.png "${PNG}"
rm "${PVR}"
exit 0
