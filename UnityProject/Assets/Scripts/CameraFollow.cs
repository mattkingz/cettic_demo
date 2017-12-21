using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CameraFollow : MonoBehaviour {

    //Objecto a seguir
    public Transform target;
    //Velocidad de seguimiento
    public float speed;
    public Vector3 cameraOffset;
    
    void Update () {

        Vector3 targetPosition = target.position + cameraOffset; 
        transform.position = Vector3.Lerp(transform.position, targetPosition, speed * Time.deltaTime);

	}
}
