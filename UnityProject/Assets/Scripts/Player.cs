using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Player : MonoBehaviour {

    public float speed;

    private Rigidbody rb;
    //Input values
    private float h, v;
	
	void Start () {
        rb = GetComponent<Rigidbody>();	
	}
	
	void Update () {
        h = Input.GetAxis("Horizontal");
        v = Input.GetAxis("Vertical");
    }

    private void FixedUpdate()
    {
        rb.AddForce(new Vector3(h, 0, v) * speed);
    }

    private void OnTriggerEnter(Collider other)
    {

        //collisiones con objetos del juego
        if(other.tag == "Item")
        {
            GameManager.Instance.ItemPickup(other.gameObject);
        }
        else if(other.tag == "Obstacle")
        {
            GameManager.Instance.ObstacleHit();
        }
        else if(other.tag == "CheckPoint")
        {
            GameManager.Instance.CheckpointReach(other.transform);
        }
        else if(other.tag == "Finish")
        {
            GameManager.Instance.FinishReach();
        }
    }

}
