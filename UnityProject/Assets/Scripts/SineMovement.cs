using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class SineMovement : MonoBehaviour {

    public float amplitude;
    public float period;
    public Vector3 axis;
    public float initialTime;

    private float previousValue = 0;
    private float currentTime;

	void Start () {
        currentTime = initialTime;
	}
	
	void Update () {
        currentTime += Time.deltaTime;
        float value = amplitude * Mathf.Sin(period * currentTime);
        float delta = value - previousValue;
        previousValue = value;

        transform.position += axis * delta;

	}
}
