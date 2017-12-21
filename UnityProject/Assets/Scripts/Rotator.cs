using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Rotator : MonoBehaviour {

    public Vector3 speed;
    //Inicia con rotacion aleatorea
    public bool randomRotation = true;

    private void Start()
    {
        if (randomRotation)
            transform.rotation = Random.rotation;
    }

    void Update () {
        transform.Rotate(speed * Time.deltaTime);	
	}
}
