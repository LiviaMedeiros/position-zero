varying vec4 v_fragmentColor;
varying vec2 v_texCoord;

const vec3  grayScale = vec3(0.33, 0.33, 0.34);
const vec3  sepiaScale = vec3(1.08, 0.75, 0.43);

void main()
{
	vec4 smpColor = v_fragmentColor * texture2D(CC_Texture0, v_texCoord);
	float grayColor = dot(smpColor.rgb, grayScale);
	vec3 sepiaColor = vec3(grayColor) * sepiaScale;
	smpColor = vec4(sepiaColor, smpColor.a);

	gl_FragColor = smpColor;
}
