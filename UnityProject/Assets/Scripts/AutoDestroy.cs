﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class AutoDestroy : MonoBehaviour {

    public float time;

	void Start () {
        GameObject.Destroy(gameObject, time);	
	}
	
}
